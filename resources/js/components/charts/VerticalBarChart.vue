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
            min: {
                type: Number,
                required: true,
            },
            max: {
                type: Number,
                required: true,
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
            this.uid = `vertical-bar-chart-${_uid}`;
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

                const maxCount = d3.max(this.aggregates, d => d.count);

                // At least half as high as it is wide, but make it bigger if the size demands it
                const height = ( width / 2 ) + ( maxCount );
                svg.style.height = height;

                const margin = ({top: 10, right: 0, bottom: 30, left: 30});

                // Make sure nothing is left in there from a previous run
                svg.selectAll("*").remove();

                svg.attr("viewBox", [0, 0, width, height]);

                const x = d3.scaleBand()
                            .domain(
                                d3.range(
                                    this.min,
                                    // range is exclusive
                                    this.max + 1,
                                    1
                            ))
                            .rangeRound([margin.left, width - margin.right])
                            .padding(0.1);


                const y = d3.scaleLinear()
                            .domain([0, maxCount])
                            .range([height - margin.bottom, margin.top]);

                svg.append("g")
                   .attr("fill", "steelblue")
                   .selectAll("rect")
                   .data(this.aggregates)
                   .join("rect")
                   .attr("x", d => x(d.key))
                   .attr("y", d => y(d.count))
                   .attr("width", x.bandwidth())
                   .attr("height", d => y(0) - y(d.count));

                svg.append("g")
                   .attr("fill", "white")
                   .attr("font-family", "sans-serif")
                   .attr("text-anchor", "middle")
                   .attr("font-size", 12)
                   .selectAll("text")
                   .data(this.aggregates)
                   .join("text")
                   .attr("x", d => x(d.key) + x.bandwidth() / 2)
                   .attr("y", d => y(d.count) + 12)
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
