let mutations = {

    /**
     * Set items
     *
     * @param state
     * @param items
     * @param totalItems
     * @private
     */
    _setItems (state, { items, totalItems }) {
        state.items = items
        state.pagination.totalItems=totalItems;
    },

    /**
     * Set current temlate
     *
     * @param state
     * @param template
     * @private
     */
    _setCurrentTemplate (state, template) {
        state.currentTemplate=template
    },
    /**
     * Crate a new template
     *
     * @param state
     * @param template
     */
    _createTemplate(state, template) {
        state.items.push(template);
    },
    /**
     * Sets pagunation
     *
     * @param state
     * @param payload
     */
    setPagination (state, payload) {
        state.pagination = payload
    },
};

export default mutations