<template>
    <div>
        <div class="row">
            <div class="col">
                <label for="">Type sensor</label>
                <select v-model="sensorType">
                    <option value="-1" selected disabled
                        >Kies een sensortype</option
                    >
                    <option
                        :value="type.id"
                        v-for="type in sensorTypes"
                        :key="type.id"
                        >{{ type.type }}</option
                    >
                </select>
            </div>
            <div class="col">
                <input :id="uid + '-limit'" type="checkbox" v-model="limit" value="1"/>
                <label :for="uid + '-limit'">Enkel recentste meting</label>
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
            data: [],
            limit: false,
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
        limit: function(val, old) {
            this.getData();
        },
        sensorType: function(val, old) {
            if (val == NaN || val <= 0) {
                return;
            }

            this.getData();
        }
    },
    methods: {
        getData: function() {
            axios
                .get("/sensors", {
                    params: {
                        type: this.sensorType,
                        data: true,
                    }
                })
                .then(res => {
                    let newData = [];
                    console.debug(res.data);
                    res.data.forEach(sensor => {
                        // Only add rooms we can draw
                        if (!(sensor.room in this.rooms)) {
                            return;
                        }

                        if (sensor.datapoints.length == 0) {
                            return;
                        }

                        let el = newData.find(e => sensor.room == e.room);
                        if (! el) {
                            newData.push({room: sensor.room, values: []});
                            el = newData.find(e => sensor.room == e.room);
                        }

                        if (this.limit) {
                            el.values.push(sensor.datapoints[0].value);
                        } else {
                            sensor.datapoints.forEach(dp => el.values.push(dp.value));
                        }
                    });
                    newData.map((el) => {
                        el.mean = d3.mean(el.values);
                        return el;
                    });
                    this.data = newData;
                })
                .catch(err => console.error(err));
        },
        getTypes: function() {
            axios
                .get("/sensortypes")
                .then(res => (this.sensorTypes = res.data))
                .catch(err => console.error(err));
        },
        redraw: function() {
            console.log("redrawing");
            const svg = d3.select(`svg#${this.uid}`);
            const width = svg.node().getBoundingClientRect().width;

            const scaling = width / img_width;

            // Make sure nothing is left in there from a previous run
            svg.selectAll("*").remove();

            svg.append("svg:image")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width", width)
                .attr("xlink:href", "/img/floorplan_10th.png");

            svg.attr("height", scaling * img_height);

            if (this.data.length == 0) {
                // We only need to draw the image, no need to continue
                return;
            }

            const firstEl = this.data.find(elem => elem.values.length > 0);
            if (firstEl == undefined) {
                console.log("no datapoints");
                return;
            }
            const first = firstEl.values[0];

            const min = this.data.reduce(
                (carry, room) =>
                    room.values.length == 0
                        ? carry
                        : Math.min(carry, room.mean),
                first
            );

            const max = this.data.reduce(
                (carry, room) =>
                    room.values.length == 0
                        ? carry
                        : Math.max(carry, room.mean),
                first
            );

            const colour = d3.scaleSequential([min, max], d3.interpolateOrRd);

            svg.append("g")
                .selectAll("a")
                .data(this.data)
                .join("svg:a")
                .attr("x", d => scaling * this.rooms[d.room].x1)
                .attr("y", d => scaling * this.rooms[d.room].y1)
                .attr("xlink:href", d => this.roomUrl(d.room))
                .append("rect")
                .attr("x", d => scaling * this.rooms[d.room].x1)
                .attr("y", d => scaling * this.rooms[d.room].y1)
                .attr(
                    "width",
                    d =>
                        scaling *
                        (this.rooms[d.room].x2 - this.rooms[d.room].x1)
                )
                .attr(
                    "height",
                    d =>
                        scaling *
                        (this.rooms[d.room].y2 - this.rooms[d.room].y1)
                )
                .attr(
                    "fill",
                    d =>
                        d3
                            .color(colour(d.mean))
                            .copy({ opacity: 0.7 }) + ""
                );

            svg.append("g")
                .attr("font-family", "sans-serif")
                .attr("text-anchor", "middle")
                .attr("font-size", 12)
                .selectAll("text")
                .data(this.data)
                .join("text")
                .attr("fill", d => {
                    let c = d3.hsl(d3.color(colour(d.mean)));
                    if (c.l > 0.5) {
                        return "black";
                    } else {
                        return "white";
                    }
                    return c.toString();
                })
                .attr("x", d => {
                    const room = this.rooms[d.room];
                    return scaling * (room.x1 + (room.x2 - room.x1) / 2);
                })
                .attr("y", d => {
                    const room = this.rooms[d.room];
                    return scaling * (room.y1 + (room.y2 - room.y1) / 2);
                })
                .attr("dy", "0.35em")
                .text(d => `${d.room} : ${d.mean.toFixed(2)}`);
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
