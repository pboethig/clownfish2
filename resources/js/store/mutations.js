let mutations = {
    _setItems (state, { items, totalItems }) {
        state.items = items
        state.pagination.totalItems=totalItems;
    },
    setPagination (state, payload) {
        state.pagination = payload
    },
}

export default mutations