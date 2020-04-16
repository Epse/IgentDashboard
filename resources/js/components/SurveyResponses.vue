<template>
    <div class="row">
        <div class="col-lg-6 my-3" v-for="question in questions" :key="question.id">
            <div class="card">
                <div class="card-header">{{ question.question }}</div>
                <div class="card-body">
                    <question-responses
                        :question="question"
                    ></question-responses>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const axios = require('axios').default;

    export default {
        props: {
            surveyId: {
                type: Number,
            },
        },
        data: function() {
            return {
                questions: [],
            };
        },
        watch: {
            surveyId: function(id, oldId) {
                if (id == null) {
                    return [];
                }

                axios.get(`/surveys/${id}/questions`)
                     .then(res => {
                         this.questions = res.data;
                     });
            },
        },
        methods: {
        },
    };
</script>

<style scoped>

</style>
