<template>
    <v-app>
       <app-bar-minimal></app-bar-minimal>
        <v-content class="fill-height component-background">
            <v-container fluid class="pa-0 fill-height">
                <v-row class="fill-height justify-center align-center">
                    <v-col
                        cols="12" sm="9" md="6" lg="5" xl="3"
                        class="pt-10 d-flex flex-column justify-center align-center fill-height"
                    >
                        <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2">Logowanie</h2>
                        <p class="subtitle-2 pa-0 ma-2 text-center">Zaloguj się na swoje konto by skorzystać ze
                            wszystkich funkcji naszego serwisu!</p>
                        <login-form></login-form>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import LoginForm from "../components/LoginForm";
import AppBarMinimal from "../components/App/AppBarMinimal";

export default {
    name: "Login",
    components: {AppBarMinimal, LoginForm},

    data() {
        return {
            darkTheme: true,
            flatNavbar: true,
            navbarBackground: "transparent",
            inset: false,
            isFalse: false,
            isTrue: true,
            snackbar: false,
            snackbarMessage: '',
        }
    },
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
