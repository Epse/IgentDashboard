<template>
    <div>
        <!-- TODO: turn this into a chart -->
        <svg :id="uid" width="100%"></svg>
    </div>
</template>

<script>
    const axios = require('axios').default;
    import * as d3 from "d3";

    // Create a unique id per component
    let _uid = 0;

    export default {
        props: {
            question: {
                type: Object,
            },
        },
        data: function () {
            return {
                answers: [],
            };
        },
        watch: {
            question: function(newQ, oldQ) {
                this.pullAnswers(newQ);
            },
            answers: function(newAnswers, oldAnswers) {
                // Redraw the graph
                this.redraw();
            },
        },
        beforeCreate() {
            this.uid = `survey-response-${_uid}`;
            _uid += 1;
        },
        created: function() {
            this.pullAnswers(this.question);
        },
        methods: {
            redraw() {
                const svg = d3.select(`svg#${this.uid}`);
                const width = svg.node()
                                 .getBoundingClientRect()
                                 .width;
                const height = svg.node()
                                  .getBoundingClientRect()
                                  .height;
                const margin = ({top: 0, right: 0, bottom: 30, left: 30});

                // Make sure nothing is left in there from a previous run
                svg.selectAll("*").remove();

                svg.attr("viewBox", [0, 0, width, height]);

                // Reflow the data
                const data = this.answers.reduce(function (carry, x) {
                    let el = carry.find(r => r && r.key === x.response);
                    if (el) {
                        el.count += 1;
                    } else {
                        carry.push({ key: x.response, count: 1});
                    }
                    return carry;
                }, []);

                const y = d3.scaleBand()
                            .domain(
                                this.question.type == 'boolean' ?
                                ['Nee', 'Ja'] :
                                d3.range(
                                this.question.min,
                                // range is exclusive
                                this.question.max + 1,
                                1
                            ))
                            .rangeRound([margin.top, height - margin.bottom])
                            .padding(0.1);

                // Cache these
                const maxCount = d3.max(data, d => d.count);

                const key = (res) => {
                    if (this.question.type == 'boolean') {
                        return res.key == 0 ? "Nee" : "Ja";
                    }
                    else {
                        return res.key;
                    }
                };

                const x = d3.scaleLinear()
                            .domain([0, maxCount])
                            .range([margin.left, width - margin.right]);

                svg.append("g")
                   .attr("fill", "steelblue")
                   .selectAll("rect")
                   .data(data)
                   .join("rect")
                   .attr("x", x(0))
                   .attr("y", d => y(key(d)))
                   .attr("width", d => x(d.count) - x(0))
                   .attr("height", y.bandwidth());

                svg.append("g")
                   .attr("fill", "white")
                   .attr("text-anchor", "end")
                   .attr("font-family", "sans-serif")
                   .attr("font-size", 12)
                   .selectAll("text")
                   .data(data)
                   .join("text")
                   .attr("x", d => x(d.count) - 4) // 4 padding
                   .attr("y", d => y(key(d)) + y.bandwidth() / 2)
                   .attr("dy", "0.35em")
                   .text(d => d.count);


                svg.append("g")
                   .attr("transform", `translate(0,${height - margin.bottom})`)
                   .call(d3.axisBottom(x));

                svg.append("g")
                   .attr("transform", `translate(${margin.left},0)`)
                   .call(d3.axisLeft(y));
            },
            pullAnswers: function(q) {
                if (q == null) {
                    return;
                }

                axios.get(`/questions/${q.id}/answers`)
                     .then(res => {
                         this.answers = res.data;
                     });
            },
        },
    };
</script>

<style scoped>

</style>
