<template>
    <v-card>
        <v-card-title>
            Verfügbare Templates
            <v-spacer></v-spacer>
            <v-text-field
                    v-model="search"
                    append-icon="search"
                    label="Search"
                    single-line
                    hide-details
            ></v-text-field>
        </v-card-title>
        <TemplateEditModal v-model="showTemplateEditModal" />

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
                <tr v-on:dblclick="openEditDialog(props.item)">
                    <td class="text-xs-left">{{ props.item.id }}</td>
                    <td>{{ props.item.is_active }}</td>
                    <td class="text-xs-left">{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ props.item.user.name }}</td>
                    <td class="text-xs-left">{{ props.item.project.name }}</td>
                    <td class="text-xs-left">{{ props.item.file_type }}</td>
                    <td class="text-xs-left">{{ props.item.file_path }}</td>
                    <td class="text-xs-left">{{ props.item.import_table }}</td>
                    <td class="text-xs-left">{{ props.item.export_table }}</td>
                    <td class="text-xs-left layout px-0">
                        <v-icon
                                class="mr-2"
                                color="success">
                            edit
                        </v-icon>
                        <v-icon
                                color="error">
                            delete
                        </v-icon>
                    </td>
                </tr>
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
    import TemplateEditModal from './TemplateEditModal';


    export default {
        components: {TemplateEditModal},
        comments:{
            TemplateEditModal
        },

        watch: {
            pagination: {
                handler() {
                    this.loading = true;

                    this.$store.dispatch('queryItems')
                        .then(result => {
                            this.loading = false
                        })
                },
                deep: true
            },
            search: function ()
            {
                this.loading=true;

                this.$store.dispatch('search', this.search);
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
                showTemplateEditModal:false,
                headers: [
                    { text: 'ID', value: 'id', width:100},
                    { text: 'Active', value: 'active' , fixed: true, width:100},
                    { text: 'Name', value: 'name' , fixed: true,width:300},
                    { text: 'User', value: 'user.name', fixed: true,width:150 },
                    { text: 'Project', value: 'project.name' , fixed: true,width:300},
                    { text: 'FileType', value: 'file_type', fixed: true , width:100},
                    { text: 'FilePath', value: 'file_path' , fixed: true,width:300},
                    { text: 'ImportTable', value: 'import_table' , fixed: true,width:100},
                    { text: 'ExportTable', value: 'export_table', fixed: true,width:100 },
                    { text: 'Actions', value: 'name', sortable: false , fixed: true}
                ],
        }
        },
        methods: {

            openEditDialog(template)
            {

                this.showTemplateEditModal=true;

                alert('dasd');

                this.$store.dispatch('setCurrentTemplate', template);


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
                    });
                }
            },

    }
</script>