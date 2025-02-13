<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col cols="12" lg="6">
                <expand-card title="Ankiety" :description="'Lista ankiet przypisanych do ' +  company.name">
                    <template slot="buttons">
                        <v-btn small icon @click="toggleCreateQuestionnaireDialog(true)">
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </template>

                    <v-container fluid class="mb-5">
                        <v-data-iterator
                            :items="questionnaires"
                            item-key="id"
                            :items-per-page="11"
                            hide-default-footer
                        >
                            <template v-slot:default="{items, isExpanded, expand}">
                                <v-row>
                                    <v-col
                                        cols="12"
                                        v-for="questionnaire in items"
                                        :key="questionnaire.id"
                                        class="py-0"
                                    >
                                        <questionnaires-list-item
                                            :name="questionnaire.name"
                                            :description="questionnaire.description"
                                            :questionnaire-id="questionnaire.id"
                                            :is-expand="isExpanded"
                                            :original-questions="questionnaire.questions"
                                        ></questionnaires-list-item>
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:no-data>
                                <v-row>
                                    <v-col cols="12" class="text-center py-5">
                                        <p class="text-subtitle-2 text--disabled">Wygląda na to, że nie ma tu jeszcze
                                            żadnych ankiet!</p>
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:loading>
                                <v-progress-circular color="secondary" indeterminate size="80"></v-progress-circular>
                            </template>
                        </v-data-iterator>
                    </v-container>
                </expand-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import VCardHeader from "../_Helpers/VCardHeader";
import QuestionnairesListItem from "./QuestionnairesListItem";
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../_Helpers/ExpandCard";
import CreateQuestionnaireDialog from "./CreateQuestionnaireDialog";

export default {
    name: "QuestionnairesList",
    components: {CreateQuestionnaireDialog, ExpandCard, QuestionnairesListItem, VCardHeader, CustomCard},
    props: ['questionnaires', 'loading'],

    data() {
        return {
            expanded: [],
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Opis', value: 'description'},
                {text: '', value: 'data-table-expand'},
            ],
            questionsHeaders: [
                {text: 'Pytanie', value: 'content'},
                {text: 'Odpowiedzi', value: 'answers'}
            ],
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company'
        }),
    },

    methods: {
        ...mapActions({
            addQuestionnaire: 'questionnaire/addQuestionnaire',
            toggleCreateQuestionnaireDialog: 'helpers/toggleCreateQuestionnaireDialog'
        }),

        getQuestionnaireLastId(questionnaires) {
            let lastId = this.questionnaires[0].id;

            questionnaires.forEach((questionnaire) => {
                lastId = questionnaire.id > lastId ? questionnaire.id : lastId;
            });

            return lastId;
        },

        getDefaultQuestionnaire() {
            return {
                id: this.getQuestionnaireLastId(this.questionnaires) + 1,
                name: null,
                description: null,
                created_at: null,
                updated_at: null,
                deleted_at: null,
                questions: []
            };
        }
    },

    created() {
    }
}
</script>

<style lang="scss">
.v-data-table > .v-data-table__wrapper tbody tr.v-data-table__expanded__content {
    box-shadow: none !important;
}
</style>
