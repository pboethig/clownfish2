let mutations = {
    GET_TEMPLATES(state, templates) {
        state.templates = templates
    },
    ADD_TEMPLATES(state, template) {
        state.templates = [...state.templates, template]
    },
    SET_CURRENT_TEMPLATE(state, template) {
        state.currentTemplate = template
    }
}

export default mutations