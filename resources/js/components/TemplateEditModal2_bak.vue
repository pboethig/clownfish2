<template>
    <div>
        <b-modal id="modal-1" @ok="handleOk" size="xl">
            <form ref="form" @submit.stop.prevent="handleSubmit">
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
                                <b-list-group-item>Project: {{project_name}}</b-list-group-item>
                                <b-list-group-item>FileType: {{file_type}}</b-list-group-item>
                                <b-list-group-item>FilePath: {{file_path}}</b-list-group-item>
                                <b-list-group-item>ImportTable: {{import_table}}</b-list-group-item>
                                <b-list-group-item>ExportTable: {{export_table}}</b-list-group-item>
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
                                    accept=".csv"
                            ></b-form-file>
                            <div class="mt-3">Selected file: {{ file_path ? file_path : '' }}</div>

                        </fieldset>
                    </b-container>
                </div>
            </form>
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
                        set: function (newValue) {
                            this.currentTemplate[0].is_active = newValue;
                        }
                    },
                name:
                    {
                        get() {
                            return this.currentTemplate[0].name;
                        },
                        set: function (newValue) {
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
                        set: function (file) {
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

            /**
             * Hide modal
             */
            hideModal() {
                this.$root.$emit('bv::hide::modal', 'modal-1')
            },

            /**
             * Returns current template
             */
            getCurrentTemplate() {
                return this.currentTemplate[0];
            },

            /**
             * Handles okay button
             */
            handleOk() {

                var self = this;

                return new Promise((resolve, reject) => {

                    axios.put('/api/templates/' + this.currentTemplate[0].id, this.currentTemplate[0])

                        .then(response => {

                            resolve(response);

                            self.upload();
                        })
                        .catch(error => {
                            reject(error.response.data)
                        })
                })
            },

            /**
             * Upload file
             */
            upload() {

                var self = this;

                let formData = new FormData();

                this.currentTemplate[0].file_path = this.currentTemplate[0].id;

                this.currentTemplate[0].import_table = this.currentTemplate[0].id + "_import_table";

                this.currentTemplate[0].export_table = this.currentTemplate[0].id + "_export_table";

                formData.append('file', this.currentTemplate[0].file);

                return new Promise((resolve, reject) => {

                    axios.post('/api/templates/' + this.currentTemplate[0].id + '/upload',

                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(response => {

                        resolve(response);

                    }).then(function () {

                        self.processUploadedFile();

                    }).catch(function (error) {

                        reject(error.response.data)

                        alert('FAILURE Uploading');
                    });
                });
            },

            /**
             * Process UploadedFile
             */
            processUploadedFile() {

                return new Promise((resolve, reject) => {

                    axios.post('/api/templates/' + this.currentTemplate[0].id + '/processUploadedFile',

                        this.currentTemplate[0]
                    ).then(response => {

                        console.log(response);

                        resolve(response);

                        window.location.reload();

                    }).catch(function (error) {

                        reject(error.response.data)

                        alert('FAILURE Processing Uploaded file');
                    });
                });
            }
        }
    }
</script>