<template>
    <div class="row">
        <div class="col">
            <svg :id="uid" width="100%"></svg>
        </div>
    </div>
</template>

<script>
import * as d3 from "d3";
const axios = require('axios').default;

let _uid = 0;

const img_width = 1653;
const img_height = 1169;

export default {
    data () {
        return {
            rooms: {},
        };
    },
    props: {

    },
    computed: {
        roomArray: function() {
            let ra = [];
            for (let [key, value] of Object.entries(this.rooms)) {
                ra.push({
                    name: key,
                    x1: value.x1,
                    x2: value.x2,
                    y1: value.y1,
                    y2: value.y2,
                });
            }
            return ra;
        },
    },
    methods: {
        redraw: function () {
            const svg = d3.select(`svg#${this.uid}`);
            const width = svg.node()
                             .getBoundingClientRect()
                             .width;

            const scaling = width / img_width;

            svg.append('svg:image')
               .attr('x', 0)
               .attr('y', 0)
               .attr('width', width)
               .attr('xlink:href', '/img/floorplan_10th.png');

            svg.attr('height', scaling * img_height);

            svg.append('g')
               .selectAll('a')
               .data(this.roomArray)
               .join('svg:a')
               .attr('x', d => scaling * d.x1)
               .attr('y', d => scaling * d.y1)
               .attr('xlink:href', d => this.roomUrl(d.name))
               .append('rect')
               .attr('x', d => scaling * d.x1)
               .attr('y', d => scaling * d.y1)
               .attr('width', d => scaling * (d.x2 - d.x1))
               .attr('height', d => scaling * (d.y2 - d.y1))
               .attr('fill', 'rgba(10,10,10,0.4)');

        },
        roomUrl(room_name) {
            return `/rooms/${room_name}`;
        },
        pullRooms () {
            axios.get('/img/floorplan_10th.json')
                 .then(res => {
                     this.rooms = res.data;
                     this.redraw();
                 })
                 .catch(err => console.error(err));
        },
    },
    beforeCreate() {
        this.uid = `rooms-${_uid}`;
        _uid += 1;
    },
    mounted() {
        this.pullRooms();
    },
}
</script>
