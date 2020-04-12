<template>
    <div class="container-fluid">
        <div class="row mb-3">
            <select v-model="survey" class="form-control">
                <option :value="null" disabled selected>Kies een enquête</option>
                <option v-for="survey in surveys" :value="survey.id" :key="survey.id">
                    {{ survey.title }}
                </option>
            </select>
        </div>
        <survey-responses
            :survey-id="survey"
        ></survey-responses>
    </div>
</template>

<script>
    const axios = require('axios').default;

    export default {
        props: {
            surveyIndexUrl: {
                type: String,
                required: true,
            },
        },
        data: function() {
            return {
                survey: null,
                surveys: [],
            };
        },
        created: function() {
            this.pullSurveys();
        },
        methods: {
            pullSurveys: function() {
                axios.get(this.surveyIndexUrl)
                     .then(res => {
                         this.surveys = res.data;
                     });
            },
        },
    };
</script>

<style scoped>

</style>
