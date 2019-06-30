let getters =
    {
        currentTemplate: state => {
            return state.currentTemplate
        },
        loading (state) {
            return state.loading
        },
        pagination (state) {
            return state.pagination
        },
        items(state) {

            return state.items;
        },
};

export default getters