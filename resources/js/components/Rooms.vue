<template>
    <div>
        <div class="row">
            <div class="col">
                <label for="">Type sensor</label>
                <select v-model="sensorType">
                    <option value="-1" selected disabled>Kies een sensortype</option>
                    <option
                        :value="type.id"
                        v-for="type in sensorTypes"
                        :key="type.id"
                        >{{ type.type }}</option
                    >
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <svg :id="uid" width="100%"></svg>
            </div>
        </div>
    </div>
</template>

<script>
import * as d3 from "d3";
const axios = require("axios").default;

let _uid = 0;

const img_width = 1653;
const img_height = 1169;

export default {
    data() {
        return {
            rooms: {},
            sensorType: -1,
            sensorTypes: [],
            data: []
        };
    },
    props: {},
    computed: {
        roomArray: function() {
            let ra = [];
            for (let [key, value] of Object.entries(this.rooms)) {
                ra.push({
                    name: key,
                    x1: value.x1,
                    x2: value.x2,
                    y1: value.y1,
                    y2: value.y2
                });
            }
            return ra;
        }
    },
    watch: {
        data: function(val, old) {
            this.redraw();
        },
        sensorType: function(val, old) {
            if (val == NaN || val <= 0) {
                return;
            }

            axios
                .get("/sensors", {
                    params: {
                        type: val
                    }
                })
                .then(res => {
                    this.data = [];
                    res.data.forEach(sensor => {
                        let el = this.data.find(r => r.room == sensor.room);
                        if (!el) {
                            this.data.push({ room: sensor.room, values: [] });
                        }
                        el = this.data.find(r => r.room == sensor.room);
                        axios
                            .get(`/sensors/${sensor.id}/data`)
                            .then(res =>
                                res.data.forEach(datapoint => {
                                    el.values.push(datapoint.value);
                                })
                            )
                            .catch(err => console.error(err));
                    });
                })
                .catch(err => console.error(err));
        }
    },
    methods: {
        getTypes: function() {
            axios
                .get("/sensortypes")
                .then(res => this.sensorTypes = res.data)
                .catch(err => console.error(err));
        },
        redraw: function() {
            const svg = d3.select(`svg#${this.uid}`);
            const width = svg.node().getBoundingClientRect().width;

            const scaling = width / img_width;

            // TODO: colour mapping for all sensor types

            svg.append("svg:image")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width", width)
                .attr("xlink:href", "/img/floorplan_10th.png");

            svg.attr("height", scaling * img_height);

            svg.append("g")
                .selectAll("a")
                .data(this.roomArray)
                .join("svg:a")
                .attr("x", d => scaling * d.x1)
                .attr("y", d => scaling * d.y1)
                .attr("xlink:href", d => this.roomUrl(d.name))
                .append("rect")
                .attr("x", d => scaling * d.x1)
                .attr("y", d => scaling * d.y1)
                .attr("width", d => scaling * (d.x2 - d.x1))
                .attr("height", d => scaling * (d.y2 - d.y1))
                .attr("fill", "rgba(10,10,10,0.4)");
        },
        roomUrl(room_name) {
            return `/rooms/${room_name}`;
        },
        pullRooms() {
            axios
                .get("/img/floorplan_10th.json")
                .then(res => {
                    this.rooms = res.data;
                    this.redraw();
                })
                .catch(err => console.error(err));
        }
    },
    beforeCreate() {
        this.uid = `rooms-${_uid}`;
        _uid += 1;
    },
    beforeMount() {
        this.getTypes();
    },
    mounted() {
        this.pullRooms();
    }
};
</script>
