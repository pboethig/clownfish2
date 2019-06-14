<template>
    <div>
        <b-modal id="modal-1">
            <div class="d-block">Hello From My Modal!</div>
            <b-button @click="hideModal">Close Me</b-button>
            <b-button @click="toggleModal">Toggle Me</b-button>
        </b-modal>
    </div>
</template>

<script>
    export default {
        methods: {
            showModal() {
                this.$root.$emit('bv::show::modal', 'modal-1')
            },
            hideModal() {
                this.$root.$emit('bv::hide::modal', 'modal-1')
            },
            toggleModal() {
                this.$root.$emit('bv::toggle::modal', 'modal-1')
            }
        }
    }
</script>