<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Uczelnie</template>
            <template v-slot:subheader>Lista uczelni w serwisie</template>
        </page-title>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <v-tabs background-color="transparent">
                        <v-tab :to="{name: 'admin-universities'}" exact>Wszystkie</v-tab>
                        <v-tab :to="{name: 'admin-universities-verification'}" exact>Do weryfikacji</v-tab>
                    </v-tabs>
                </custom-card>
            </v-col>
        </v-row>

        <v-row no-gutters class="pt-10">
            <v-col cols="12">
                <router-view></router-view>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import {mapActions} from "vuex";

export default {
    name: "TheAdminUniversities",
    components: {CustomCard, PageTitle},

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        })
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Panel Administratora', to: {name: 'admin'}, exact: true},
            {text: 'Uczelnie', disabled: true}
        ]);
    }
}
</script>

<style scoped>

</style>
