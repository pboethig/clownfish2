<template>
    <div>
        <TemplateEditGrid/>
    </div>
</template>
<script>
    import TemplateEditGrid from './TemplateEditGrid'
    import store from '../store/index'
    export default {
        store,
        name: 'Templates',
        data() {
            return {

            }
        },
        components: {
            TemplateEditGrid,
            store
        },
        methods: {

        },
    }
</script>