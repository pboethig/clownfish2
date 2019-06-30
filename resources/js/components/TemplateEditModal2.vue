<template>
    <v-card>
        <v-card-title>
            Nutrition
            <v-spacer></v-spacer>
            <v-text-field
                    v-model="search"
                    append-icon="search"
                    label="Search"
                    single-line
                    hide-details
            ></v-text-field>
        </v-card-title>
        <v-data-table
                must-sort
                :headers="headers"
                :pagination.sync="pagination"
                :rows-per-page-items="[10,50,200,500,1000]"
                :total-items="pagination.totalItems"
                :loading="loading"
                :items="items"
                class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.item.is_active }}</td>
                <td class="text-xs-right">{{ props.item.id }}</td>
                <td class="text-xs-right">{{ props.item.name }}</td>
                <td class="text-xs-right">{{ props.item.user.name }}</td>
                <td class="text-xs-right">{{ props.item.project.name }}</td>
                <td class="text-xs-right">{{ props.item.file_type }}</td>
                <td class="text-xs-right">{{ props.item.file_path }}</td>
                <td class="text-xs-right">{{ props.item.import_table }}</td>
                <td class="text-xs-right">{{ props.item.export_table }}</td>
                <td class="justify-center layout px-0">
                    <v-icon
                            small
                            class="mr-2"
                            color="success">
                        edit
                    </v-icon>
                    <v-icon
                            small
                            color="error">
                        delete
                    </v-icon>
                </td>
            </template>
            <template v-slot:no-results>
                <v-alert :value="true" color="error" icon="warning">
                    Your search for "{{ search }}" found no results.
                </v-alert>
            </template>
        </v-data-table>
    </v-card>
</template>
<script>

    import {mapState} from 'vuex'

    export default {

        watch: {
            pagination: {
                handler() {
                    this.loading = true

                    console.log('watch load pagination');
                    this.$store.dispatch('queryItems')
                        .then(result => {
                            this.loading = false
                        })
                },
                deep: true
            },
            search: function ()
            {

            }

        },

        computed:
            {
                ...mapState(['currentTemplate','pagination', 'items','templates']),
                pagination: {
                    get: function () {
                        return this.$store.getters.pagination
                    },
                    set: function (value) {
                        this.$store.commit('setPagination', value)
                    }
                },
                items () {

                    return this.$store.getters.items
                }

            },
        data() {
            return {
                search:'',
                loading: false,
                isModalVisible: false,
                headers: [
                    { text: 'Active', value: 'active' ,align:'left'},
                    { text: 'ID', value: 'id' },
                    { text: 'Name', value: 'name' ,align:'left'},
                    { text: 'User', value: 'user.name' },
                    { text: 'Project', value: 'project.name' },
                    { text: 'FileType', value: 'file_type' },
                    { text: 'FilePath', value: 'file_path' },
                    { text: 'ImportTable', value: 'import_table' },
                    { text: 'ExportTable', value: 'export_table' },
                    { text: 'Actions', value: 'name', sortable: false }
                ],
        }
        },
        methods: {

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
                    });
                }
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
</script>