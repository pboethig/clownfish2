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

    GET_TEMPLATES({commit}) {
        axios.get('/api/templates')
            .then(res => {
                {
                    commit('GET_TEMPLATES', res.data)
                }
            })
            .catch(err => {
                console.log(err)
            })
    },
    GET_CURRENT_TEMPLATE({commit}) {
        axios.get('/api/templates')
            .then(res => {
                {
                    commit('GET_CURRENT_TEMPLATE', res.data)
                }
            })
            .catch(err => {
                console.log(err)
            })
    },
    setCurrentTemplate({commit}, template) {

        alert(template);

        commit('SET_CURRENT_TEMPLATE', template)
    }
}

export default actions