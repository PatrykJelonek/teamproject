<template>
    <v-app>
       <app-bar-minimal></app-bar-minimal>
        <v-main>
            <v-content class="fill-height component-background">
                <v-row class="fill-height justify-center align-center">
                    <v-col
                        cols="12" sm="9" md="6" lg="5" xl="3"
                        class="pt-10 d-flex flex-column justify-center align-center fill-height"
                    >
                        <v-icon large color="primary">mdi-lock-reset</v-icon>
                        <h2>Wyślij link do zresetowania hasła</h2>
                        <p class="text-center text-body-2">Podaj email używany w naszym serwisie by otrzymać na niego link który umożliwi Ci zresetowanie hasła</p>
                        <v-container>
                            <forgot-password-form></forgot-password-form>
                        </v-container>
                    </v-col>
                </v-row>
            </v-content>
            <snackbar></snackbar>
        </v-main>
    </v-app>
</template>

<script>
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {mapActions} from "vuex";
import Snackbar from "../components/_Helpers/Snackbar";
import ForgotPasswordForm from "../components/_Other/ForgotPasswordForm";
import AppBarMinimal from "../components/App/AppBarMinimal";

setInteractionMode('eager');

export default {
    name: "ForgotPassword",

    components: {
        AppBarMinimal,
        ForgotPasswordForm,
        Snackbar,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            email: null,
        }
    },

    methods: {
        ...mapActions({
            forgotPassword: 'auth/forgotPassword',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        async submit() {
            this.$refs.observer.validate();
            await this.forgotPassword(this.email).then(() => {
                this.setSnackbar({message: 'Link do zresetowania hasła został wysłany!', color: 'success'});
            }).catch((e) => {
                this.setSnackbar({
                    message: 'Nie udało się wysłać linku, skontaktuj się z administracją serwisu!',
                    color: 'error'
                });
            });
        }
    }
}
</script>

<style scoped>

</style>
