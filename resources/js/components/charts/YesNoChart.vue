<template>
    <div>
        <svg :id="uid" width="100%"></svg>
    </div>
</template>

<script>
    import * as d3 from "d3";

    // Create a unique id per component
    let _uid = 0;

    export default {
        props: {
            aggregates: {
                type: Array,
            },
        },
        data: function () {
            return {
            };
        },
        watch: {
            aggregates: function(newAnswers, oldAnswers) {
                // Redraw the graph
                this.redraw();
            },
        },
        beforeCreate() {
            this.uid = `yes-no-chart-${_uid}`;
            _uid += 1;
        },
        created: function() {
        },
        computed: {
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
                const margin = ({top: 10, right: 0, bottom: 30, left: 30});

                // Make sure nothing is left in there from a previous run
                svg.selectAll("*").remove();

                svg.attr("viewBox", [0, 0, width, height]);

                const y = d3.scaleBand()
                            .domain(['Nee', 'Ja'])
                            .rangeRound([margin.top, height - margin.bottom])
                            .padding(0.1);

                // Cache these
                const maxCount = d3.max(this.aggregates, d => d.count);

                const key = (res) => {
                    return res.key == 0 ? "Nee" : "Ja";
                };

                const x = d3.scaleLinear()
                            .domain([0, maxCount])
                            .range([margin.left, width - margin.right]);

                svg.append("g")
                   .attr("fill", "steelblue")
                   .selectAll("rect")
                   .data(this.aggregates)
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
                   .data(this.aggregates)
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
        },
    };
</script>

<style scoped>

</style>
