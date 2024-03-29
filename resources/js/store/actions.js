let actions = {

    /**
     * Add new template
     *
     * @param commit
     * @param template
     * @returns {Promise<any>}
     * @constructor
     */
    createTemplate({commit}, template) {

        return new Promise((resolve, reject) => {
            axios.post(`/api/templates`, template)
                .then(response => {
                    resolve(response)

                    context.commit('_createTemplate', template);

                }).catch(err => {
                reject(err)
            })
        })
    },

    /**
     * Set databaseTables
     * @param context
     * @param tables
     */
    setDatabaseTables(context, databaseTables) {
        context.commit('_setDatabaseTables', databaseTables);
    },


    /**
     * Set conditions
     * @param context
     * @param tables
     */
    setConditions(context, conditions) {
        context.commit('_setConditions', conditions);
    },

    /**
     * Set current temnplate
     *
     * @param context
     * @param template
     */
    setCurrentTemplate(context, template) {
        context.commit('_setCurrentTemplate', template);

    },

    /**
     * Set current importTable
     * @param context
     * @param importTable
     */
    setCurrentImportTable(context, importTable) {
        context.commit('_setCurrentImportTable', importTable);

    },

    /**
     * Search templates
     * @param context
     * @param searchTerm
     */
    search(context, searchTerm) {
        axios.defaults.params = {};
        axios.defaults.params[ 'filter' ] = {
            searchTerm:searchTerm,
            pagination:context.pagination,
        };

        axios.get('/api/templates/')
            .then(res => {
                context.commit('_setItems',  res.data,  res.data.length);
            })
            .catch(err => console.log(err.response.data)).finally(function () {
            context.loading=false;
        })
    },

    /**
     * Set Items
     *
     * @param context
     * @param items
     * @param totalItems
     * @private
     */
    _setItems(context, items, totalItems) {
        context.commit('_setItems', {items, totalItems})
    },
    /**
     * Delete template
     *
     * @param context
     * @param template
     */
    deleteTemplate(context, template) {
        context.loading=true;
        axios.delete('/api/templates/'+template.id)
            .then(res => {
                context.dispatch('queryItems');
            })
            .catch(err => console.log(err.response.data)).finally(function () {
            context.loading=false;
        })
    },
    /**
     * set selectedConditions
     *
     * @param context
     * @param selectedConditions
     */
    setSelectedConditions(context, selectedConditions) {

       context.commit("_setSelectedConditions", selectedConditions);
    },

    /**
     * Save conditions
     *
     * @param context
     * @param conditions
     */
    saveConditions(context, conditions)
    {
        axios.post('/api/conditions/', conditions

        ).then(response => {

            //context.commit('_set', {items, totalItems})

        }).catch(function (error) {

            console.log(error);

            alert('FAILURE Uploading');
        });

    },


    /**
     * Query templates
     *
     * @param context
     * @param searchTerm
     * @returns {Promise<any>}
     */
        queryItems(context, searchTerm) {

        return new Promise((resolve, reject) => {

            const {sortBy, descending, page, rowsPerPage} = context.state.pagination;

                axios.get('/api/templates/'

                ).then(response => {

                    let items = response.data.slice();
                    const totalItems = items.length;

                    if (sortBy) {
                        items = items.sort((a, b) => {
                            const sortA = a[sortBy]
                            const sortB = b[sortBy]

                            if (descending) {
                                if (sortA < sortB) return 1
                                if (sortA > sortB) return -1
                                return 0
                            } else {
                                if (sortA < sortB) return -1
                                if (sortA > sortB) return 1
                                return 0
                            }
                        })
                    }

                    if (rowsPerPage > 0) {
                        items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
                    }

                    context.commit('_setItems', {items, totalItems})

                    resolve();

                }).catch(function (error) {

                    console.log(error);

                    alert('FAILURE Uploading');
                });
        })
    }
};

export default actions