<template>
    <v-app>
        <v-app-bar app flat>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-app-bar-title></v-app-bar-title>
        </v-app-bar>
        <the-app-navigation-drawer :items="items"></the-app-navigation-drawer>
    </v-app>
</template>

<script>
import TheAppNavigationDrawer from "../components/App/TheAppNavigationDrawer";

export default {
    name: "TestApp",
    components: {TheAppNavigationDrawer},
    data() {
        return {
            items: [
                {text: 'Dashboard', icon: 'mdi-view-dashboard-outline', to: {name: 'panel'}},
                {
                    text: 'Uczelnia',
                    icon: 'mdi-view-dashboard-outline',
                    children: [
                        {text: 'Informacje', icon: 'mdi-view-dashboard-outline', to: {name: 'university-overview'}},
                        {text: 'Umowy', icon: 'mdi-file-document-multiple-outline', to: {name: 'university-agreements'}},
                        {text: 'Praktyki i Staże', icon: 'mdi-certificate-outline', to: {name: 'university-internships'}},
                        {text: 'Studenci', icon: 'mdi-account-supervisor', to: {name: 'university-students'}},
                        {text: 'Pracownicy', icon: 'di-account-multiple-outline', to: {name: 'university-workers'}},
                        {text: 'Ustawienia', icon: 'mdi-cog', to: {name: 'university-setting'}},
                    ]
                },
                {
                    text: 'Firma',
                    icon: 'mdi-view-dashboard-outline',
                    children: [
                        {text: 'Informacje', icon: 'mdi-view-dashboard-outline', to: {name: 'company-overview'}},
                        {text: 'Oferty Praktyk', icon: 'mdi-newspaper-variant-multiple-outline', to: {name: 'company-offers'}},
                        {text: 'Umowy', icon: 'di-file-document-multiple-outline', to: {name: 'company-agreements'}},
                        {text: 'Pracownicy', icon: 'mdi-account-multiple-outline', to: {name: 'company-workers'}},
                        {text: 'Ustawienia', icon: 'mdi-cog', to: {name: 'company-settings'}},
                    ]
                },
                {
                    text: 'Panel Administratora',
                    icon: 'mdi-view-dashboard-outline',
                    children: [
                        {text: 'Dashboard', icon: 'mdi-monitor-dashboard', to: {name: 'admin'}},
                        {text: 'Statystyki', icon: 'mdi-chart-box-outline', to: {name: 'admin'}},
                        {text: 'Użytkownicy', icon: 'mdi-account-group-outline', to: {name: 'admin-users'}},
                        {
                            text: 'Oferty Praktyk',
                            icon: 'mdi-newspaper-variant-multiple-outline',
                            children: [
                                {text: 'Do Akceptacji', to: {name: 'admin-offers'}},
                                {text: 'Wszystkie', to: {name: 'admin-offers'}}
                            ]
                        },
                        {text: 'Ustawienia', icon: 'mdi-application-cog', to: {name: 'admin-settings'}},
                    ]
                }
            ]
        }
    },
}
</script>

<style lang="scss">

</style>
