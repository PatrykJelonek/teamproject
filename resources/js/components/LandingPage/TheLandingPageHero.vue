<template>
    <v-container class="py-15">
        <v-row class="pt-15">
            <v-col cols="12" md="12" lg="8" xl="5">
                <v-row>
                    <v-col cols="12">
                        <h2 class="text-h4 text-md-h2 font-weight-bold mb-3" v-bind:class="this.$vuetify.breakpoint.smAndDown ? 'text-center' : ''">
                            Internetowy System Planowania i&nbsp;Rozliczania Studenckich Praktyk Zawodowych
                        </h2>
                    </v-col>
                    <v-col cols="8" md="6" lg="6" xl="6" offset="2" offset-sm="2" offset-md="0">
                        <p class="text--secondary text-subtitle-1 text-md-h6" v-bind:class="this.$vuetify.breakpoint.smAndDown ? 'text-center' : ''">
                            <b>InternApp</b> to aplikacja internetowa przenosząca tradycyjny system zarządzania praktykami studenckimi do sieci. Jej zadaniem jest wsparcie uczelni, przemysłu, a przede wszystkim studentów.
                        </p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" v-bind:class="this.$vuetify.breakpoint.smAndDown ? 'text-center' : ''">
                        <v-btn dark color="green accent-4" :to="{name: 'register'}">
                            Załóż bezpłatne konto
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="0" md="5" lg="4" xl="7" >
                <v-fade-transition>
                    <v-img style="margin-top: 100px" src="../img/hero_image_desktop.png" alt="Aplikacja InternApp na komputery osobiste" class="rounded hidden-lg-and-down"></v-img>
                </v-fade-transition>
                <v-fade-transition>
                    <v-img src="../img/hero_image_mobile.png" width="400px" alt="Aplikacja InternApp na telefony komórkowe" class="rounded hidden-xl-and-up hidden-xl-only hidden-md-and-down" ></v-img>
                </v-fade-transition>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "TheLandingPageHero"
}
</script>

<style scoped>

</style>
