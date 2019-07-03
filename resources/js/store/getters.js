let getters =
    {
        currentTemplate: state => {
            return state.currentTemplate
        },
        currentImportTable: state => {
            return state.currentImportTable
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
        databaseTables(state) {

            return state.databaseTables;
        },
        conditions(state){
            return state.conditions;
        },
};

export default getters