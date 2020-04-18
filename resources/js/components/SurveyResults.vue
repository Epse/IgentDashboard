<template>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <select v-model="surveyId" class="form-control">
                    <option :value="null" disabled selected>Kies een enquête</option>
                    <option v-for="survey in surveys" :value="survey.id" :key="survey.id">
                        {{ survey.title }}
                    </option>
                </select>
            </div>
        </div>

        <hr/>

        <div class="row mb-3" v-if="survey != null">
            <div class="col">
                <h2>{{ survey.title }}</h2>
                <p>
                    {{ survey.description }}
                </p>
            </div>
        </div>

        <survey-responses
            :survey-id="surveyId"
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
                surveyId: null,
                surveys: [],
            };
        },
        computed: {
            survey: function() {
                if (this.surveyId == null) {
                    return;
                }

                for (const s of this.surveys) {
                    if (s.id == this.surveyId) {
                        return s;
                    }
                }

                return null;
            },
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
        components: {
            'survey-responses': require('./SurveyResponses.vue').default,
        },
    };
</script>

<style scoped>

</style>
