<template>
    <svg :id="uid" width="100%"></svg>
</template>

<script>
import * as d3 from "d3";
const _ = require('lodash');

// Create a unique id per component
let _uid = 0;

export default {
    props: {
        answers: {
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
        this.uid = `map-chart-${_uid}`;
        _uid += 1;
    },
    created: function() {
    },
    computed: {
        aggregates: function() {
            return _.sortBy(this.answers.reduce(function(carry, x) {
                let el = carry.find(r => r && r.room == x.room);
                if (el) {
                    el.values.push(x.response);
                } else {
                    carry.push({room: x.room, values: [x.response]});
                }
                return carry;
            }, []), ['room']);
        },
    },
    methods: {
        redraw() {
            const svg = d3.select(`svg#${this.uid}`);
            const width = svg.node()
                             .getBoundingClientRect()
                             .width;
            const padding = 2; // Just a magic number

            // Amount of squares on the x-axis
            // 4 is just a number that looks pretty good
            const Nx = Math.min(4, this.aggregates.length);
            const side = ( width - Nx * 2 * padding ) / Nx;

            const x = i => ( 2 * padding + side ) * ( i % Nx ) + padding;
            const y = i => ( 2 * padding + side ) * Math.floor(i / Nx) + padding;

            const height = y(this.aggregates.length - 1) + side + padding * 2;
            svg.attr("viewBox", [0, 0, width, height]);

            // Make sure nothing is left in there from a previous run
            svg.selectAll("*").remove();

            const color = d3.scaleLinear()
                            .domain([this.min, this.max])
                            .range(['#FF0000', '#00F000']);

            svg.append('g')
               .selectAll('rect')
               .data(this.aggregates)
               .join('rect')
               .attr('x', (d, i) => x(i))
               .attr('y', (d, i) => y(i))
               .attr('fill', d => color(d3.mean(d.values)))
               .attr('width', side)
               .attr('height', side);

            svg.append('g')
               .attr('fill', 'white')
               .attr('font-family', 'sans-serif')
               .attr('text-anchor', 'middle')
               .attr('font-size', 16)
               .selectAll('text')
               .data(this.aggregates)
               .join('text')
               .attr('x', (d, i) => x(i) + side / 2)
               .attr('y', (d, i) => y(i) + side / 2)
               .attr('dy', '0.35em')
               .text(d => `${d.room} : ${d3.mean(d.values).toFixed(2)}`);
        },
    },
};
</script>
