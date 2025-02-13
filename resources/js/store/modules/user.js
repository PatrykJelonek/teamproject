import vue from "vue";
import router from "../../router/routers";
import moment from "moment";
import axios from "axios";

export default {
    namespaced: true,

    state: {
        loggedUser: '',
        validationErrors: '',
        userUniversities: [],
        userCompanies: [],
        userCompaniesLoading: false,
        roles: [],
        journalEntries: [],
        internships: [],
        internshipsLoading: true,
        interns: [],
        newInternships: [],
        newInternshipsLoading: false,
        acceptedInternships: [],
        acceptedInternshipsLoading: false,
        userUniversitiesLoading: false,
        userMessages: [],
        userMessagesLoading: false,
        user: null,
        userLoading: false,
        userNotifications: [],
        userNotificationsLoading: false,
        userUnreadNotifications: [],
        userUnreadNotificationsLoading: false,
    },

    getters: {
        userUniversities(state) {
            return state.userUniversities;
        },

        userUniversitiesLoading(state) {
            return state.userUniversitiesLoading;
        },

        userCompanies(state) {
            return state.userCompanies;
        },

        userCompaniesLoading(state) {
            return state.userCompaniesLoading;
        },

        userMessages(state) {
            return state.userMessages;
        },

        userMessagesLoading(state) {
            return state.userMessagesLoading;
        },

        roles(state) {
            return state.roles;
        },

        journalEntries(state) {
            return state.journalEntries;
        },

        internships(state) {
            return state.internships;
        },

        internshipsLoading(state) {
            return state.internshipsLoading;
        },

        newInternships(state) {
            return state.newInternships;
        },

        newInternshipsLoading(state) {
            return state.newInternshipsLoading;
        },

        acceptedInternships(state) {
            return state.acceptedInternships;
        },

        acceptedInternshipsLoading(state) {
            return state.acceptedInternshipsLoading;
        },

        interns(state) {
            return state.interns;
        },

        user(state) {
            return state.user;
        },

        userLoading(state) {
            return state.userLoading;
        },

        userNotifications(state) {
            return state.userNotifications;
        },

        userNotificationsLoading(state) {
            return state.userNotificationsLoading;
        },

        userUnreadNotifications(state) {
            return state.userUnreadNotifications;
        },

        userUnreadNotificationsLoading(state) {
            return state.userUnreadNotificationsLoading;
        },
    },

    mutations: {
        CREATE_USER_ACCOUNT(state, message) {
            state.validationErrors = '';
            router.push('/login');
        },

        ACCOUNT_VALIDATION(state, errors) {
            state.validationErrors = errors;
        },

        SET_USER_UNIVERSITIES(state, data) {
            state.userUniversities = data;
        },

        SET_USER_UNIVERSITIES_LOADING(state, data) {
            state.userUniversitiesLoading = data;
        },

        SET_USER_MESSAGES(state, data) {
            state.userMessages = data;
        },

        SET_USER_MESSAGES_LOADING(state, data) {
            state.userMessagesLoading = data;
        },

        SET_USER_COMPANIES(state, data) {
            state.userCompanies = data;
        },

        SET_USER_COMPANIES_LOADING(state, data) {
            state.userCompaniesLoading = data;
        },

        SET_ROLES(state, data) {
            state.roles = data;
        },

        SET_JOURNALS_ENTRIES(state, data) {
            state.journalEntries = data;
        },

        SET_INTERNSHIPS(state, data) {
            state.internships = data;
        },

        SET_INTERNSHIPS_LOADING(state, data) {
            state.internshipsLoading = data;
        },

        SET_NEW_INTERNSHIPS(state, data) {
            state.newInternships = data;
        },

        SET_NEW_INTERNSHIPS_LOADING(state, data) {
            state.newInternshipsLoading = data;
        },

        SET_ACCEPTED_INTERNSHIPS(state, data) {
            state.acceptedInternships = data;
        },

        SET_ACCEPTED_INTERNSHIPS_LOADING(state, data) {
            state.acceptedInternshipsLoading = data;
        },

        SET_INTERNS(state, data) {
            state.interns = data;
        },

        SET_USER(state, data) {
            state.user = data;
        },

        SET_USER_LOADING(state, data) {
            state.userLoading = data;
        },

        SET_USER_NOTIFICATIONS(state, data) {
            state.userNotifications = data;
        },

        SET_USER_NOTIFICATIONS_LOADING(state, data) {
            state.userNotificationsLoading = data;
        },

        SET_USER_UNREAD_NOTIFICATIONS(state, data) {
            state.userUnreadNotifications = data;
        },

        SET_USER_UNREAD_NOTIFICATIONS_LOADING(state, data) {
            state.userUnreadNotificationsLoading = data;
        },

        UNSHIFT_USER_NOTIFICATION(state, data) {
            state.userNotifications.unshift(data);
        },

        UNSHIFT_USER_UNREAD_NOTIFICATION(state, data) {
            state.userUnreadNotifications.unshift(data);
        },

        MARK_AS_READ(state, id) {
            state.userUnreadNotifications.forEach((notification, index) => {
                if(notification.id === id) {
                    state.userUnreadNotifications.splice(index, 1);
                }
            });

            state.userNotifications.forEach((notification, index) => {
               if(notification.id === id) {
                   state.userNotifications[index].read_at = moment();
               }
            });
        },

        SET_NOTIFICATION_COUNT(state) {
            const pattern = /^\(\d+\)/;

            if (state.userUnreadNotifications.length === 0 || pattern.test(document.title)) {
                document.title = document.title.replace(pattern, state.userUnreadNotifications.length === 0 ? "" : "(" + state.userUnreadNotifications.length + ")");
            } else {
                document.title = "(" + state.userUnreadNotifications.length + ") " + document.title;
            }
        }
    },

    actions: {
        createUserAccount({commit}, account) {
            return axios({
                method: 'post',
                url: '/api/users',
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                data: {
                    firstName: account.firstName,
                    lastName: account.lastName,
                    email: account.email,
                    phone: account.phone,
                    password: account.password,
                }
            }).then(res => {
                commit('CREATE_USER_ACCOUNT', res.data);
            }).catch(err => {
                if (err.response.status === 422){
                    commit('ACCOUNT_VALIDATION', err.response.data.errors)
                }
            });
        },

        createUser({commit}, user) {
          return axios.post('/api/users', user);
        },

        async fetchUserUniversities({ commit }) {
            commit('SET_USER_UNIVERSITIES_LOADING', true);
            try {
                let response = await axios.get('/api/me/universities');
                commit('SET_USER_UNIVERSITIES', response.data);
                commit('SET_USER_UNIVERSITIES_LOADING', false);
            } catch (e) {
                commit('SET_USER_UNIVERSITIES', []);
                commit('SET_USER_UNIVERSITIES_LOADING', false);
            }
        },

        async fetchUserMessages({ commit }) {
            commit('SET_USER_MESSAGES_LOADING', true);
            try {
                let response = await axios.get('/api/me/messages');
                commit('SET_USER_MESSAGES', response.data);
                commit('SET_USER_MESSAGES_LOADING', false);
            } catch (e) {
                commit('SET_USER_MESSAGES', []);
                commit('SET_USER_MESSAGES_LOADING', false);
            }
        },

        async fetchUserCompanies({ commit }) {
            commit('SET_USER_COMPANIES_LOADING', true);
            try {
                let response = await axios.get('/api/me/companies');
                commit('SET_USER_COMPANIES', response.data);
                commit('SET_USER_COMPANIES_LOADING', false);
            } catch (e) {
                commit('SET_USER_COMPANIES', []);
                commit('SET_USER_COMPANIES_LOADING', false);
            }
        },

        async fetchUserRoles({ commit }) {
          try {
              let response = await axios.get('/api/user/roles');
              commit('SET_ROLES', response.data.data);
          } catch (e) {
              commit('SET_ROLES', []);
          }
        },

        async fetchJournalEntries({ commit }) {
            try {
                let response = await axios.get('/api/journals');
                commit('SET_JOURNALS_ENTRIES', response.data.data);
            } catch(e) {
                commit('SET_JOURNALS_ENTRIES', []);
            }
        },

        async fetchInternships({ commit }) {
            commit('SET_INTERNSHIPS_LOADING', true);
            try {
                let response = await axios.get('/api/me/internships');
                commit('SET_INTERNSHIPS', response.data);
                commit('SET_INTERNSHIPS_LOADING', false);
            } catch (e) {
                commit('SET_INTERNSHIPS', []);
                commit('SET_INTERNSHIPS_LOADING', false);
            }
        },

        async fetchInterns({commit}, id) {
            try {
                let response = await axios.get(`/api/user/interns`);
                commit('SET_INTERNS', response.data.data);
            } catch(e) {
                commit('SET_INTERNS', []);
            }
        },

        async fetchAcceptedInternships({ commit }) {
            commit('SET_ACCEPTED_INTERNSHIPS_LOADING', true);
            try {
                let response = await axios.get('/api/me/internships/accepted');
                commit('SET_ACCEPTED_INTERNSHIPS', response.data);
                commit('SET_ACCEPTED_INTERNSHIPS_LOADING', false);
            } catch (e) {
                commit('SET_ACCEPTED_INTERNSHIPS', []);
                commit('SET_ACCEPTED_INTERNSHIPS_LOADING', false);
            }
        },

        async fetchNewInternships({ commit }) {
            commit('SET_NEW_INTERNSHIPS_LOADING', true);
            try {
                let response = await axios.get('/api/me/internships/new');
                commit('SET_NEW_INTERNSHIPS', response.data);
                commit('SET_NEW_INTERNSHIPS_LOADING', false);
            } catch (e) {
                commit('SET_NEW_INTERNSHIPS', []);
                commit('SET_NEW_INTERNSHIPS_LOADING', false);
            }
        },

        async fetchUser({ commit }, id) {
            commit('SET_USER_LOADING', true);
            try {
                let response = await axios.get(`/api/users/${id}`);
                commit('SET_USER', response.data);
                commit('SET_USER_LOADING', false);
            } catch (e) {
                commit('SET_USER', []);
                commit('SET_USER_LOADING', false);
            }
        },

        createOneOnOneChat({ commit }, id) {
            return axios.post(`/api/chats/`, {
               secondUserId: id
            });
        },

        async fetchUserNotifications({commit}) {
            commit('SET_USER_NOTIFICATIONS_LOADING', true);
            try {
                let response = await axios.get(`/api/me/notifications`);
                commit('SET_USER_NOTIFICATIONS', response.data);
                commit('SET_USER_NOTIFICATIONS_LOADING', false);
            } catch (e) {
                commit('SET_USER_NOTIFICATIONS', []);
                commit('SET_USER_NOTIFICATIONS_LOADING', false);
            }
        },

        async unshiftUserNotification({commit}, notification) {
            commit('UNSHIFT_USER_NOTIFICATION', notification);
        },

        async fetchUserUnreadNotifications({commit}) {
            commit('SET_USER_UNREAD_NOTIFICATIONS_LOADING', true);
            try {
                let response = await axios.get(`/api/me/notifications/unread`);
                commit('SET_USER_UNREAD_NOTIFICATIONS', response.data);
                commit('SET_USER_UNREAD_NOTIFICATIONS_LOADING', false);
                commit('SET_NOTIFICATION_COUNT');
            } catch (e) {
                commit('SET_USER_UNREAD_NOTIFICATIONS', []);
                commit('SET_USER_UNREAD_NOTIFICATIONS_LOADING', false);
            }
        },

        async unshiftUserUnreadNotification({commit}, notification) {
            commit('UNSHIFT_USER_UNREAD_NOTIFICATION', notification);
            commit('SET_NOTIFICATION_COUNT');
        },

        markNotificationAsRead({commit}, id) {
            return axios.put(`/api/me/notifications/${id}`);
        },

        activateUser({commit}, activationToken) {
            return axios.put(`/api/users/activate/${activationToken}`);
        }
    }
};
