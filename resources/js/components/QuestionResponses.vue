<template>
    <div>
        <yes-no-chart
            v-if="question.type == 'boolean' && false"
            :aggregates="aggregates"
        ></yes-no-chart>
        <vertical-bar-chart
            v-if="question.type == 'scale' && false"
            :aggregates="aggregates"
            :min="question.min"
            :max="question.max"
        ></vertical-bar-chart>
        <map-chart
            :answers="answers"
            :min="question.min"
            :max="question.max"
        ></map-chart>
        <details>
            <summary>Statistische gegevens</summary>
            <small v-if="question.type == 'boolean'">
                Het antwoord <em>Nee</em> wordt beschouwd als de waarde 0.
                <em>Ja</em> komt overeen met 1.
            </small>
            <table class="table table-sm table-hover">
                <tbody>
                    <tr>
                        <th scope="row">Gemiddelde</th>
                        <td>{{ mean }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Mediaan</th>
                        <td>{{ median }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Standaardafwijking</th>
                        <td>{{ deviation }}</td>
                    </tr>
                </tbody>
            </table>
        </details>
    </div>
</template>

<script>
const axios = require("axios").default;
import * as d3 from "d3";
import orderBy from 'lodash/orderBy';

export default {
    props: {
        question: {
            type: Object
        }
    },
    data: function() {
        return {
            answers: [],
            polling: null,
        };
    },
    watch: {
        question: function(newQ, oldQ) {
            this.pullAnswers(newQ);
        }
    },
    created: function() {
        this.pullAnswers(this.question);
        this.polling = setInterval(() => {
            this.pullAnswers(this.question);
        }, 5000 + Math.floor(Math.random() * 1000)); // Spread the delays and load
    },
    beforeDestroy () {
        clearInterval(this.polling);
    },
    computed: {
        aggregates() {
            return this.answers.reduce(function(carry, x) {
                let el = carry.find(r => r && r.key === x.response);
                if (el) {
                    el.count += 1;
                } else {
                    carry.push({ key: x.response, count: 1 });
                }
                return carry;
            }, []);
        },
        mean() {
            return d3.mean(this.answers, d => d.response);
        },
        median() {
            return d3.median(this.answers, d => d.response);
        },
        deviation() {
            return d3.deviation(this.answers, d => d.response);
        }
    },
    methods: {
        pullAnswers: function(q) {
            // This is a method because axios.get is async.
            if (q == null) {
                return;
            }

            if (this.answers.length == 0) {
                axios.get(`/questions/${q.id}/answers`).then(res => {
                    this.answers = res.data;
                });
            } else {
                const sorted = orderBy(this.answers, [o => o.created_at], ["desc"]);
                const lastDate = sorted[0].created_at;
                axios.get(`/questions/${q.id}/answers`, {
                    params: {
                        since: lastDate,
                    }
                }).then(res => {
                    this.answers = this.answers.concat(res.data);
                });
            }

        }
    },
    components: {
        "vertical-bar-chart": require("./charts/VerticalBarChart.vue").default,
        "yes-no-chart": require("./charts/YesNoChart.vue").default,
        "map-chart": require('./charts/MapChart.vue').default,
    }
};
</script>

<style scoped></style>
