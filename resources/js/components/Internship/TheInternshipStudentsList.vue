<template>
    <div>
        <internship-student-list-item
            v-for="internshipStudent in internshipStudents"
            :key="internshipStudent.id"
            :student-full-name="internshipStudent.user.first_name + ' ' + internshipStudent.user.last_name"
            :student-index="internshipStudent.student_index"
            :internship-end-date="internshipEndDate"
        ></internship-student-list-item>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import InternshipStudentListItem from "./InternshipStudentListItem";

    export default {
        name: "TheInternshipStudentsList",
        components: {InternshipStudentListItem},
        props: ['internshipId','internshipEndDate'],

        computed: {
            ...mapGetters({
                internshipStudents: 'internship/internshipStudents'
            })
        },

        methods: {
            ...mapActions({
                fetchInternshipStudents: 'internship/fetchInternshipStudents',
            }),
        },

        created() {
            this.fetchInternshipStudents(this.$route.params.internshipId ? this.$route.params.internshipId : this.internshipId).then(() => {

            }).catch((e) => {
                console.error(e);
            });
        }
    }
</script>

<style scoped>

</style>
