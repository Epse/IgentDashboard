<template>
    <div>
        <!-- TODO: turn this into a chart -->
        <ul>
            <li v-for="answer in answers" :key="answer.id">
                {{ answer.response }}
            </li>
        </ul>
    </div>
</template>

<script>
    const axios = require('axios').default;

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
        },
        created: function() {
            this.pullAnswers(this.question);
        },
        methods: {
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
