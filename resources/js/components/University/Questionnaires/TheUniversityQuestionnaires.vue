<template>
    <v-container fluid class="pa-0">
        <template v-if="!universityLoading || !isQuestionnairesLoading">
            <create-questionnaire-dialog :is-university-questionnaire="true"></create-questionnaire-dialog>

            <page-title>
                <template v-slot:default>Ankiety</template>
                <template v-slot:subheader>Lista ankiet uczelni {{ university.name }}</template>
                <template v-slot:actions>
                    <v-btn
                        color="primary"
                        outlined
                        @click="toggleCreateQuestionnaireDialog(true)"
                        v-has-university-role="['deanery_worker','university_owner','university_supervisor']"
                    >
                        Dodaj Ankietę
                    </v-btn>
                </template>
            </page-title>

            <v-row class="mt-7">
                <v-col cols="12">
                    <custom-card :loading="isQuestionnairesLoading">
                        <custom-card-title>
                            <template v-slot:default>Lista ankiet</template>
                        </custom-card-title>
                        <v-data-table
                            :headers="headers"
                            :items="questionnaires"
                            :item-key="questionnaires.id"
                            class="component-background cursor-pointer"
                            no-data-text="Niestety, ale aktualnie nie mu tu żadnych ankiet!"
                            loading-text="Pobieranie listy ankiet..."
                        >
                            <template v-slot:item.user="{item}">
                                <v-avatar :size="30" class="mr-2" rounded :color="item.user.avatar_url ? '' : 'primary'">
                                    <v-img :src="item.user.avatar_url ? '/'+item.user.avatar_url : ''"
                                           :alt="'Awatar użytkownika ' + item.user.full_name"></v-img>
                                </v-avatar>
                                {{ item.user.full_name }}
                            </template>
                            <template v-slot:item.questions="{item}">
                                {{ item.questions.length }}
                            </template>
                            <template v-slot:item.created_at="{item}">
                                {{ formatDate(item.created_at) }}
                            </template>
                            <template v-slot:item.actions="{item}">
                                <v-menu offset-y class="component-background">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            icon
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <v-icon>mdi-dots-vertical</v-icon>
                                        </v-btn>
                                    </template>
                                    <v-list dense color="component-background" class="cursor-pointer">
                                        <v-list-item
                                            @click="$router.push({name: 'edit-questionnaire', params: {slug: $route.params.slug, questionnaireId: item.id}})">
                                            <v-list-item-title v-has-university-role="['deanery_worker','university_owner','university_supervisor']">
                                                Edytuj ankietę
                                            </v-list-item-title>
                                        </v-list-item>
                                        <v-list-item @click="$router.push({name: 'questionnaire', params: {questionnaireId: item.id}})">
                                            <v-list-item-title>
                                                Wyświetl ankietę
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </template>
                        </v-data-table>
                    </custom-card>
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
import QuestionnairesList from "../../Questionnaires/QuestionnairesList";
import CreateQuestionnaireDialog from "../../Questionnaires/CreateQuestionnaireDialog";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import moment from "moment";
import PageLoader from "../../_General/PageLoader";

export default {
    name: "TheUniversityQuestionnaires",
    components: {PageLoader, CustomCardTitle, CustomCard, PageTitle, CreateQuestionnaireDialog, QuestionnairesList},

    data() {
        return {
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Autor', value: 'user'},
                {text: 'Liczba pytań', value: 'questions'},
                {text: 'Data utworzenia', value: 'created_at'},
                {text: 'Akcje', value: 'actions'},
            ]
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
            questionnaires: 'questionnaire/questionnaires',
            isQuestionnairesLoading: 'questionnaire/isQuestionnairesLoading',
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            toggleCreateQuestionnaireDialog: 'helpers/toggleCreateQuestionnaireDialog',
            fetchQuestionnaires: 'questionnaire/fetchUniversitiesQuestionnaires',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY - HH:mm');
        }
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {
                text: this.university.name ?? 'Uczelnia',
                to: {name: 'university', params: {slug: this.$route.params.slug}},
                exact: true
            },
            {text: 'Ankiety', to: {name: 'university-questionnaires'}, exact: true},
        ]);

        this.fetchQuestionnaires(this.$route.params.slug).then(() => {}).catch((error) => {})
    }
}
</script>

<style scoped>

</style>
