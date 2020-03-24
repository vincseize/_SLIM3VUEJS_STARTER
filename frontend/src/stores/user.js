export default {
    namespaced: true,
    state: {
        id: null,
        firstName: '',
        lastName: '',
        pseudo: '',
        email: '',
    },
    mutations: {
        init(state, data) {
            state.id = data.id;
            state.firstName = data.first_name;
            state.lastName = data.last_name;
            state.pseudo = data.pseudo;
            state.email = data.email;
        },

        reset(state) {
            state.id = null;
            state.firstName = '';
            state.lastName = '';
            state.pseudo = '';
            state.email = '';
        },
    },
    getters: {
        fullName: (state) => `${state.firstName} ${state.lastName}`
    },
    actions: {},
};
