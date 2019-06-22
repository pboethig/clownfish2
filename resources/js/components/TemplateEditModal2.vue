<template>
    <div>
        <b-modal id="modal-1">
            <div v-if="this.getCurrentTemplate().id">
                <b-container fluid>
                    <fieldset>
                        <legend>
                            <h2>Info</h2>
                        </legend>

                        <b-list-group>
                            <b-list-group-item>Active: {{is_active}}</b-list-group-item>
                            <b-list-group-item>ID: {{id}}</b-list-group-item>
                            <b-list-group-item>Name: {{name}}</b-list-group-item>
                            <b-list-group-item>User: {{user_id}}) Name {{user_name}}</b-list-group-item>
                            <b-list-group-item>Project: {{project_id}} ) Name: {{project_name}}</b-list-group-item>
                            <b-list-group-item>FileType: {{file_type}}</b-list-group-item>
                            <b-list-group-item>FilePath: {{file_path}}</b-list-group-item>
                            <b-list-group-item>ImportTable:  {{import_table}}</b-list-group-item>
                            <b-list-group-item>ExportTable:  {{export_table}}</b-list-group-item>
                        </b-list-group>
                    </fieldset>
                    <br/>
                    <fieldset>
                        <legend><h2>Edit Data</h2></legend>
                        <b-form-group label="Is active:">
                            <input type="checkbox" id="checkbox" v-model="is_active">
                            <label for="checkbox">{{is_active}}</label>

                        </b-form-group>

                        <b-form-group label="Name:">
                            <b-form-input :id="name" v-model="name"></b-form-input>
                        </b-form-group>

                        <b-form-file
                                v-model="file_path"
                                :state="Boolean(file_path)"
                                placeholder="Choose a file..."
                                drop-placeholder="Drop file here..."
                        ></b-form-file>
                        <div class="mt-3">Selected file: {{ file_path ? file_path : '' }}</div>

                    </fieldset>
                </b-container>
            </div>
            <b-button @click="hideModal">Close Me</b-button>
        </b-modal>
    </div>
</template>

<script>

    import {mapState} from 'vuex'

    export default {
        computed:
            {
                ...mapState(['currentTemplate']),
                is_active:
                    {
                        get() {

                            return this.currentTemplate[0].is_active;
                        },
                        set: function(newValue) {


                            this.currentTemplate[0].is_active = newValue;

                        }
                    },
                name:
                    {
                        get() {

                            return this.currentTemplate[0].name;
                        },
                        set: function(newValue) {
                            this.currentTemplate[0].name = newValue;

                        }
                    },
                user_id:
                    {
                        get() {

                            return this.currentTemplate[0].user.id;
                        }
                    },
                user_name:
                    {
                        get() {

                            return this.currentTemplate[0].user.name;
                        }
                    },
                project_id:
                    {
                        get() {

                            return this.currentTemplate[0].project.name;
                        }
                    },
                project_name:
                    {
                        get() {

                            return this.currentTemplate[0].project.name;
                        }
                    },
                id:
                    {
                        get() {

                            return this.currentTemplate[0].id;
                        }
                    }
                ,
                file_type:
                    {
                        get() {

                            return this.currentTemplate[0].file_type;
                        }
                    },
                file_path:
                    {
                        get() {

                            return this.currentTemplate[0].file_path;
                        },
                        set: function(file) {
                            this.currentTemplate[0].file_path = file.name;
                            this.currentTemplate[0].file = file;

                        }
                    },
                import_table:
                    {
                        get() {

                            return this.currentTemplate[0].import_table;
                        }
                    },
                export_table:
                    {
                        get() {

                            return this.currentTemplate[0].import_table;
                        }
                    }
            },
        data() {
            return {
                rowData: null,
                gridApi: null,
                columnApi: null,
                autoGroupColumnDef: null,
                isModalVisible: false,
            }
        },
        methods: {
            hideModal() {
                this.$root.$emit('bv::hide::modal', 'modal-1')
            },
            getCurrentTemplate() {
                return this.currentTemplate[0];
            }
        }
    }
</script>