let actions = {
    ADD_TEMPLATE({commit}, template) {

        return new Promise((resolve, reject) => {
            axios.post(`/api/templates`, template)
                .then(response => {
                    resolve(response)
                }).catch(err => {
                reject(err)
            })
        })
    },


    setCurrentTemplate(context, template) {
        context.commit('_setCurrentTemplate', template);

    },
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

    _setItems(context, items, totalItems) {
        context.commit('_setItems', {items, totalItems})
    },


    queryItems (context, searchTerm) {

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