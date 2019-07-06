let getters =
    {
        /**
         * return current template
         *
         * @param state
         * @returns {getters.currentTemplate|(function(*))|null|getters.currentTemplate|currentTemplate}
         */
        currentTemplate: state => {
            return state.currentTemplate
        },
        /**
         * return current template
         *
         * @param state
         * @returns {getters.currentImportTable|(function(*))|Array|getters.currentImportTable|currentImportTable}
         */
        currentImportTable: state => {
            return state.currentImportTable
        },

        /**
         * Return current loading state
         *
         * @param state
         * @returns {*}
         */
        loading (state) {
            return state.loading
        },

        /**
         * Return pagination
         *
         * @param state
         * @returns {getters.pagination|(function(*))|state.pagination|{totalItems, rowsPerPageItems, sortBy, page, rowsPerPage, descending}|__webpack_exports__.default.props.pagination|{default, type}|*}
         */
        pagination (state) {
            return state.pagination
        },

        /**
         * Return template items
         * @param state
         * @returns {*}
         */
        items(state) {

            return state.items;
        },

        /**
         * Return database tables
         *
         * @param state
         * @returns {getters.databaseTables|(function(*))|Array|getters.databaseTables|databaseTables}
         */
        databaseTables(state) {

            return state.databaseTables;
        },

        /**
         * return conditions
         *
         * @param state
         * @returns {getters.conditions|(function(*))|default.computed.conditions|{set, get}|Array|conditions|*}
         */
        conditions(state){
            return state.conditions;
        },

        /**
         * Return selected conditions
         *
         * @param state
         * @returns {getters.selectedConditions|(function(*))|Array|selectedConditions|{targetColumns, freetext, operators, sourceColumns}}
         */
        selectedConditions(state) {
            return state.selectedConditions;
        }
};

export default getters