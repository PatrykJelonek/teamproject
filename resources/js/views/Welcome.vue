<template>
    <v-container fluid>
        <v-row class="mt-10">
            <v-col>
                <h2 class="text--welcome text-h3 font-weight-black">Cześć, <br> {{user.first_name + " " + user.last_name}}</h2>
            </v-col>
        </v-row>
        <v-row class="mt-10">
            <v-col cols="12" md="12" lg="12" xl="6">
                <the-dashboard-internships></the-dashboard-internships>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import VuexTabsItems from "../components/_Helpers/VuexTabsItems";
    import Sidebar from "../components/_Helpers/Sidebar";
    import {mapActions, mapGetters} from "vuex";
    import TheDashboardInternships from "../components/Dashboard/TheDashboardInternships";
    import TheDashboardMessages from "../components/Dashboard/TheDashboardMessages";
    import TheDashboardActivity from "../components/Dashboard/TheDashboardActivity";
    import TheDashboardOthers from "../components/Dashboard/TheDashboardOthers";

    export default {
        name: "Welcome",
        components: {
            TheDashboardOthers,
            TheDashboardActivity, TheDashboardMessages, TheDashboardInternships, VuexTabsItems, Sidebar},

        data() {
            return {

            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },

        methods: {
            ...mapActions({
                setBreadcrumbs: 'helpers/setBreadcrumbs'
            }),
        },

        created() {
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}}
            ])
        },
    }
</script>

<style scoped>
    .text--welcome {
        font-size: 35px;
    }
</style>
