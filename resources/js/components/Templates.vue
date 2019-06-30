<template>
    <div>
        <TemplateEditModal2/>
    </div>
</template>
<script>
    import {AgGridVue} from "ag-grid-vue";
    import TemplateEditModal2 from './TemplateEditModal2'
    import store from '../store/index'
    export default {
        store,
        name: 'Templates',
        data() {
            return {

            }
        },
        components: {
            TemplateEditModal2,
            store
        },
        methods: {

        },
    }
</script>