<template>
    <v-container fluid class="pa-0 ma-0">
        <v-stepper alt-labels v-model="createOwnAgreementStepper" flat color="component-background">
            <!-- STEPPER HEADER -->
            <v-stepper-header class="component-background mt-0">
                <v-stepper-step
                    step="1"
                    :rules="[() => !stepOneErrors]"
                    :complete="stepOneCompleted"
                >
                    Miejsce praktyk
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                    step="2"
                    :rules="[() => !stepTwoErrors]"
                    :complete="stepTwoCompleted"
                >
                    Dane praktyki
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                    step="3"
                    :rules="[() =>
                    !stepThreeErrors]"
                    :complete="stepThreeCompleted"
                >
                    Dane umowy
                </v-stepper-step>
            </v-stepper-header>

            <v-divider></v-divider>

            <!-- STEPPER CONTENTS -->
            <v-stepper-items>
                <v-stepper-content step="1" class="component-background pa-0">
                    <template>
                        <v-row no-gutters class="pa-5">
                            <v-col cols="12">
                                <validation-provider
                                    vid="company.id"
                                    rules="required"
                                    v-slot="{ errors }"
                                >
                                    <v-autocomplete
                                        v-model="data.company.id"
                                        :items="companies"
                                        item-text="name"
                                        item-value="id"
                                        :loading="companiesLoading"
                                        outlined
                                        dense
                                        label="Firma"
                                        hide-details="auto"
                                        clearable
                                    ></v-autocomplete>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12" class="mt-5 text-center">
                                <p class="text-body-2 ma-0">
                                    Nie znalazłeś szukanej firmy?
                                    <span
                                        class="primary--text cursor-pointer">Uzupełnij poniższy formularz!</span>
                                </p>
                            </v-col>
                        </v-row>
                    </template>
                    <v-divider></v-divider>
                    <validation-observer ref="observerStepOne" v-slot="{ validate }">
                        <v-form>
                            <template>
                                <v-row no-gutters class="pa-5">
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="company.name"
                                            rules="required|max:64"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.name"
                                                outlined
                                                dense
                                                label="Nazwa firmy"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="8" class="pr-5">
                                        <validation-provider
                                            vid="company.street"
                                            rules="required|max:64"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.street"
                                                outlined
                                                dense
                                                label="Ulica"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="4">
                                        <validation-provider
                                            vid="company.streetNumber"
                                            rules="required|max:8"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.streetNumber"
                                                outlined
                                                dense
                                                label="Numer"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="4" class="pr-5">
                                        <validation-provider
                                            vid="company.city.postcode"
                                            rules="required|max:6"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.city.postcode"
                                                outlined
                                                dense
                                                v-mask="'##-###'"
                                                label="Kod pocztowy"
                                                @change="(val) => getCity(val)"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="8">
                                        <validation-provider
                                            vid="company.city.name"
                                            rules="required_if:company.id"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.city.name"
                                                outlined
                                                dense
                                                label="Miasto"
                                                disabled
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="company.companyCategoryId"
                                            rules="required|numeric"
                                            v-slot="{ errors }"
                                        >
                                            <v-autocomplete
                                                v-model="data.company.companyCategoryId"
                                                :items="companyCategories"
                                                item-text="name"
                                                item-value="id"
                                                :loading="companyCategoriesLoading"
                                                outlined
                                                dense
                                                label="Kategoria"
                                                :error-messages="errors"
                                            ></v-autocomplete>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="6" class="pr-5">
                                        <validation-provider
                                            vid="company.email"
                                            rules="required|email"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.email"
                                                outlined
                                                dense
                                                label="Email"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="6">
                                        <validation-provider
                                            vid="company.phone"
                                            rules="required|max:16"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.phone"
                                                outlined
                                                dense
                                                prefix="+48 "
                                                v-mask="'###-###-###'"
                                                label="Telefon kontaktowy"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="company.website"
                                            rules="required|max:64"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.website"
                                                outlined
                                                dense
                                                prefix="https://"
                                                label="Strona internetowa"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="company.description"
                                            rules=""
                                            v-slot="{ errors }"
                                        >
                                            <v-textarea
                                                v-model="data.company.description"
                                                outlined
                                                dense
                                                label="Opis firmy"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-form>
                    </validation-observer>
                </v-stepper-content>

                <v-stepper-content step="2" class="component-background pa-0">
                    <validation-observer ref="observerStepTwo" v-slot="{ validate }">
                        <v-form>
                            <template>
                                <v-row no-gutters class="pa-5">
                                    <v-col cols="10" class="pr-5">
                                        <validation-provider
                                            vid="agreement.name"
                                            rules="required|max:80"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.agreement.name"
                                                outlined
                                                dense
                                                label="Nazwa praktyki"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="2">
                                        <validation-provider
                                            vid="agreement.placesNumber"
                                            rules="required|min_value:0|numeric"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.agreement.placesNumber"
                                                outlined
                                                dense
                                                label="Ilość miejsc"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="6" class="pr-5">
                                        <v-menu
                                            v-model="dateFromPicker"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider
                                                    vid="agreement.dateFrom"
                                                    rules="required"
                                                    v-slot="{ errors }"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateFrom"
                                                        label="Data od"
                                                        readonly
                                                        outlined
                                                        dense
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
                                                v-model="data.agreement.dateFrom"
                                                @input="dateFromPicker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-menu
                                            v-model="dateToPicker"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider
                                                    vid="agreement.dateTo"
                                                    rules="required"
                                                    v-slot="{ errors }"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateTo"
                                                        label="Data do"
                                                        readonly
                                                        outlined
                                                        dense
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
                                                v-model="data.agreement.dateTo"
                                                @input="dateToPicker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.universitySupervisorId"
                                            rules="required"
                                            v-slot="{ errors }"
                                        >
                                            <v-autocomplete
                                                v-model="data.agreement.universitySupervisorId"
                                                :items="universityWorkers"
                                                item-text="full_name"
                                                item-value="id"
                                                outlined
                                                dense
                                                label="Opiekun praktyk"
                                                :error-messages="errors"
                                            ></v-autocomplete>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.program"
                                            rules="required"
                                            v-slot="{ errors }"
                                        >
                                            <v-textarea
                                                v-model="data.agreement.program"
                                                outlined
                                                dense
                                                label="Program praktyk"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.schedule"
                                            rules="required"
                                            v-slot="{ errors }"
                                        >
                                            <v-textarea
                                                v-model="data.agreement.schedule"
                                                outlined
                                                dense
                                                label="Harmonogram praktyk"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-form>
                    </validation-observer>
                </v-stepper-content>

                <v-stepper-content step="3" class="component-background pa-0">
                    <validation-observer ref="observerStepThree" v-slot="{ validate }">
                        <v-form>
                            <template>
                                <v-row no-gutters class="pa-5">
                                    <v-col cols="12">
                                        <v-menu
                                            v-model="dateSigningPicker"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider
                                                    vid="agreement.signingDate"
                                                    rules=""
                                                    v-slot="{ errors }"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.signingDate"
                                                        label="Data podpisania umowy"
                                                        readonly
                                                        outlined
                                                        dense
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
                                                v-model="data.agreement.signingDate"
                                                @input="dateSigningPicker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.content"
                                            rules=""
                                            v-slot="{ errors }"
                                        >
                                            <v-textarea
                                                v-model="data.agreement.content"
                                                outlined
                                                dense
                                                label="Treść umowy"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.attachments"
                                            rules=""
                                            v-slot="{ errors }"
                                        >
                                            <v-file-input
                                                v-model="data.agreement.attachments"
                                                outlined
                                                dense
                                                multiple
                                                prepend-icon=""
                                                prepend-inner-icon="mdi-paperclip"
                                                label="Załączniki do umowy"
                                            ></v-file-input>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-checkbox
                                            class="ma-0"
                                            v-model="data.agreement.active"
                                            label="Umowa aktywna (widoczna dla studentów)"
                                            hide-details="auto"
                                        ></v-checkbox>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-form>
                    </validation-observer>
                </v-stepper-content>

                <v-stepper-content step="4" class="component-background pa-0">
                    <v-row no-gutters>
                        <v-col cols="12" class="d-flex justify-center align-center pa-5">
                            <v-progress-circular indeterminate color="primary"></v-progress-circular>
                        </v-col>
                    </v-row>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
        <custom-card-footer>
            <template v-slot:left v-if="createOwnAgreementStepper > 1 && createOwnAgreementStepper < 4">
                <v-btn outlined color="secondary" @click="setCreateOwnAgreementStepper(createOwnAgreementStepper - 1);">
                    Cofnij
                </v-btn>
            </template>
            <template v-slot:right>
                <template v-if="createOwnAgreementStepper === 3">
                    <v-btn outlined color="primary" @click="send">
                        Wyślij
                    </v-btn>
                </template>
                <template v-else-if="createOwnAgreementStepper > 0 && createOwnAgreementStepper < 3">
                    <v-btn outlined color="primary" @click="setCreateOwnAgreementStepper(createOwnAgreementStepper + 1);">
                        Dalej
                    </v-btn>
                </template>
            </template>
        </custom-card-footer>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver, extend} from "vee-validate";
import CustomCardFooter from "../../_General/CustomCardFooter";

export default {
    name: "CreateOwnAgreementForm",

    props: ['step'],

    components: {
        CustomCardFooter,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            d: true,
            stepper: 1,
            dateFromPicker: null,
            dateToPicker: null,
            dateSigningPicker: null,
            selectedUniversity: null,
            data: {
                company: {
                    id: null,
                    name: null,
                    street: null,
                    streetNumber: null,
                    city: {
                        id: null,
                        name: null,
                        postcode: null,
                    },
                    email: null,
                    phone: null,
                    website: null,
                    companyCategoryId: null,
                    description: null,
                },
                agreement: {
                    name: null,
                    dateFrom: null,
                    dateTo: null,
                    program: null,
                    schedule: null,
                    content: null,
                    companyId: null,
                    universitySlug: null,
                    universitySupervisorId: null,
                    offerId: null,
                    userId: null,
                    attachments: [],
                    placesNumber: null,
                    offerPlacesNumber: null,
                    active: false,
                    signingDate: null,
                },
            },
            attachmentsFiles: [],
            canSearchable: null,
            searchCompanyInput: null,
            stepOneErrors: false,
            stepTwoErrors: false,
            stepThreeErrors: false,
            stepOneCompleted: false,
            stepTwoCompleted: false,
            stepThreeCompleted: false,
        }
    },

    computed: {
        ...mapGetters({
            companyCategories: 'company/companyCategories',
            companyCategoriesLoading: 'company/companyCategoriesLoading',
            city: 'city/city',
            cityLoading: 'city/cityLoading',
            companies: 'company/companies',
            companiesLoading: 'company/companiesLoading',
            offerCategories: 'offer/offerCategories',
            offerCategoriesLoading: 'offer/offerCategoriesLoading',
            universityWorkers: 'university/workers',
            createOwnAgreementStepper: 'helpers/createOwnAgreementStepper',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
            setSnackbar: 'snackbar/setSnackbar',
            fetchCompanyCategories: 'company/fetchCompanyCategories',
            fetchCompanies: 'company/fetchCompanies',
            fetchCity: 'city/fetchCity',
            fetchOfferCategories: 'offer/fetchOfferCategories',
            createStudentOwnInternship: 'student/createStudentOwnInternship',
            fetchUniversityWorkers: 'university/fetchWorkers',
            setCreateOwnAgreementStepper: 'helpers/setCreateOwnAgreementStepper',
            createOwnAgreement: 'university/createOwnAgreement',
            fetchUniversityAgreements: 'university/fetchAgreements',
        }),

        postcodePattern() {
            switch (this.data.company.city.postcode.length) {
                case 2:
                    this.data.company.city.postcode += '-';
            }
        },

        getCity(postcode) {
            if (postcode.length === 6) {
                this.fetchCity(postcode).then(() => {
                    this.data.company.city.name = this.city.name ?? '';
                    this.data.company.city.id = this.city.id ?? '';
                })
            }
        },

        async send()
        {
            console.log('adsasdadadas');
            this.$store.commit('helpers/SET_CREATE_OWN_AGREEMENT_LOADING', true);
            await this.createOwnAgreement({slug: this.$route.params.slug, data: this.data}).then(() => {
                this.$store.commit('helpers/SET_CREATE_OWN_AGREEMENT_LOADING', false);
                this.fetchUniversityAgreements(this.$route.params.slug);
                this.toggleDialog({key: 'DIALOG_FIELD_CREATE_OWN_AGREEMENT', val: false});
                this.setSnackbar({message: "Umowa została dodana!", color: 'success'});
            }).catch((e) => {
                if (e.response.status === 422) {
                    this.$refs.observerStepOne.setErrors(e.response.data.errors);
                    this.$refs.observerStepTwo.setErrors(e.response.data.errors);
                    this.$refs.observerStepThree.setErrors(e.response.data.errors);
                    this.setCreateOwnAgreementStepper(1);
                }

                this.$store.commit('helpers/SET_CREATE_OWN_AGREEMENT_LOADING', false);
            });
        }
    },

    created() {
        this.fetchCompanies().then(() => {

        }).catch((e) => {

        });

        this.fetchCompanyCategories().then(() => {

        }).catch((e) => {

        });

        this.fetchOfferCategories().then(() => {

        }).catch((e) => {

        });

        this.fetchUniversityWorkers(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    },

    watch: {
        createOwnAgreementStepper: function (newVal, oldVal) {
            if (newVal > oldVal) {
                switch (oldVal) {
                    case 1:
                        if (this.data.company.id === null || this.data.company.name !== null) {
                            this.$refs.observerStepOne.validate().then((isValid) => {
                                if (isValid) {
                                    this.stepOneErrors = false;
                                    this.stepOneCompleted = true;
                                } else {
                                    this.stepOneErrors = true;
                                    this.setCreateOwnAgreementStepper(1);
                                }
                            });
                        } else {
                            this.stepOneCompleted = true;
                            this.stepOneErrors = false;
                            this.$refs.observerStepOne.reset();
                        }
                        break;
                    case 2:
                        this.$refs.observerStepTwo.validate().then((isValid) => {
                            if (isValid) {
                                this.stepTwoErrors = false;
                                this.stepTwoCompleted = true;
                            } else {
                                this.stepTwoErrors = true;
                                this.setCreateOwnAgreementStepper(2);
                            }
                        });
                        break;
                    case 3:
                        this.$refs.observerStepThree.validate().then((isValid) => {
                            if (isValid) {
                                this.stepThreeErrors = false;
                                this.stepThreeCompleted = true;
                            } else {
                                this.stepThreeErrors = true;
                                this.setCreateOwnAgreementStepper(3);
                            }
                        });
                        break;
                }
            }
        }
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
