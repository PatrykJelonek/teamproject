<template>
    <v-container fluid class="pa-0">
        <template v-if="!companyLoading">
            <page-title>
                <template v-slot:default>
                    {{ company.draft ? company.draft_name : company.name }}
                    <v-chip small v-if="company.draft" color="disabled" outlined>Draft</v-chip>
                    <v-chip small outlined v-else-if="!company.verified">Niezweryfikowany</v-chip>
                </template>
                <template v-slot:subheader>{{ company.description }}</template>
            </page-title>

            <v-row>
                <v-col cols="12">
                    <the-company-details
                        :name="company.draft ? company.draft_name : company.name"
                        :category="company.category.name"
                        :address="company.street + ' ' + company.street_number + ', ' + company.city.name"
                        :email="company.draft ? company.draft_email : company.email"
                        :phone="company.phone"
                        :website="company.website"
                        :description="company.description"
                        :draft="company.draft"
                        :verified="company.verified"
                    ></the-company-details>
                </v-col>
            </v-row>
        </template>
        <template v-else>
            <page-loader></page-loader>
        </template>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
import PageLoader from "../../_General/PageLoader";
import TheCompanyDetails from "./TheCompanyDetails";

export default {
    name: "TheCompanyOverview",
    components: {TheCompanyDetails, PageLoader, PageTitle},

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading',
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {
                text: (this.company.draft ? this.company.draft_name : this.company.name) ?? 'Firma',
                to: {name: 'company', params: {slug: this.$route.params.slug}},
                exact: true
            },
        ])
    }
}
</script>

<style scoped>

</style>
