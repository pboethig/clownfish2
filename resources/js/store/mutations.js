let mutations = {
    _setItems (state, { items, totalItems }) {
        state.items = items
        state.pagination.totalItems=totalItems;
    },
    _setCurrentTemplate (state, template) {
        state.currentTemplate=template
    },
    setPagination (state, payload) {
        state.pagination = payload
    },
}

export default mutations