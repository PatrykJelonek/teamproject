<template>
    <v-card>
        <v-list-item two-line>
            <v-list-item-content>
                <div class="overline mb-4 text-uppercase">Kod dostępu</div>
                <v-list-item-title id="accessCodeTitle" class="headline mb-1">{{ selectedUniversity.access_code }}
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon @click="copyAccessCode" class="ml-3 body-1" v-on="on">mdi-content-copy</v-icon>
                        </template>
                        <span>Kliknij by skopiować!</span>
                    </v-tooltip>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-card-actions>
            <v-btn @click="generateNewAccessCode(selectedUniversity.id)" text>Generuj Nowy</v-btn>
        </v-card-actions>
        <v-snackbar v-model="snackbar" color="success" bottom right>
            Skopiowano kod!
            <v-btn icon dark @click="snackbar = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-snackbar>
    </v-card>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "UniversityAccessCode",

        data() {
            return {
                accessCode: "",
                snackbar: false
            }
        },

        computed: {
            ...mapGetters({
                selectedUniversity: 'university/selectedUniversity',
            }),
        },

        methods: {
            ...mapActions({
                generateNewAccessCode: 'university/generateCode'
            }),

            copyAccessCode() {
                navigator.clipboard.writeText(this.selectedUniversity.access_code).then(() => {
                    this.snackbar = true;
                });
            },
        },

        created() {
            this.accessCode = this.selectedUniversity.access_code;
        }
    }
</script>

<style scoped>

</style>
