<template>
    <v-slide-item
        class="ml-5"
        v-slot="{ active, toggle }"
    >
        <v-card
            nav
            flat
            outlined
            width="250"
            @click="cardOnClick(); toggle();"
            :color="$route.params.studentIndex === index ? 'primary' : 'cardBackground'"
        >
            <v-list dense color="card-background">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>{{ fullname }}</v-list-item-title>
                        <v-list-item-subtitle>{{ index }}</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action v-if="grade">
                        <v-tooltip bottom color="component-background">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-on="on"
                                    v-bind="attrs"
                                >{{ grade }}</v-btn>
                            </template>
                            <span>Ocena z praktyki</span>
                        </v-tooltip>
                    </v-list-item-action>
                </v-list-item>
            </v-list>
        </v-card>
    </v-slide-item>
</template>

<script>
import router from "../../router/routers";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "InternshipStudent",
    props: ['fullname', 'index', 'grade'],

    computed: {
        ...mapGetters({
            internship: 'internship/internship'
        }),
    },

    methods: {
        ...mapActions({
            fetchStudentJournalEntries: 'student/fetchStudentJournalEntries',
            fetchStudentTasks: 'student/fetchStudentTasks',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            setDialogArgs: 'helpers/setDialogArgs',
            fetchInternshipStudent: 'internship/fetchInternshipStudent',
        }),

        cardOnClick() {
            if (this.$route.params.studentIndex !== this.index) {
                this.fetchInternshipStudent({internship: this.$route.params.internshipId, student: this.index});
                this.setDialogArgs({key: 'DIALOG_FIELD_RATE_STUDENT', val: {student: this.student}});
                this.$store.commit('student/SET_STUDENT', this.student);
                router.push({name: 'internship-student', params: {studentIndex: this.index}});
                this.fetchStudentJournalEntries({internshipId: this.$route.params.internshipId, studentIndex: this.index});
                this.fetchStudentTasks({internshipId: this.$route.params.internshipId, studentIndex: this.index});

                this.setBreadcrumbs([
                    {text: 'Panel', to: {name: 'panel'}, exact: true},
                    {text: 'Praktyki i Staże', to: {name: 'admin'}, exact: true},
                    {
                        text:  this.internship.offer.name ?? ' ',
                        to: {name: 'internship', params: {internshipId: this.$route.params.internshipId}},
                        exact: true
                    },
                    {
                        text: this.fullname,
                        to: {name: 'internship-student', params: {internshipId: this.$route.params.internshipId, studentIndex: this.index}},
                        exact: true
                    },
                ]);
            }
        },
    }
}
</script>

<style scoped>

</style>
