<template>
    <div>
        <TemplateEditModal2/>
        <b-button @click="getSelectedRows()">Edit Template</b-button>
        <ag-grid-vue style="width: 100%; height: 800px;"
                     class="ag-theme-material"
                     :columnDefs="columnDefs"
                     :rowData="rowData"
                     rowSelection="multiple"

                     @grid-ready="onGridReady">
        </ag-grid-vue>
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
                columnDefs: null,
                rowData: null,
                gridApi: null,
                columnApi: null,
                autoGroupColumnDef: null,
                isModalVisible: false,

            }
        },
        components: {
            AgGridVue,
            TemplateEditModal2,
            store
        },
        methods: {

            onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
            },

            /**
             * Gets selected row
             */
            getSelectedRows() {
                const selectedNodes = this.gridApi.getSelectedNodes();

                if (!selectedNodes.length) {
                    this.$swal('Select at least one row');
                }

                const selectedData = selectedNodes.map(node => node.data);

                const selectedDataStringPresentation = selectedData.map(node => node.id + ' ' + node.name).join(', ');
                //alert(`Selected nodes: ${selectedDataStringPresentation}`);

                this.showModal(selectedData);

            },
            /**
             * Shows modal
             */
            showModal(selectedData) {
                this.setCurrentTemplate(selectedData);
                this.$root.$emit('bv::show::modal', 'modal-1', '#btnShow')
            },
            /**
             * Hides modal
             */
            hideModal() {
                this.$root.$emit('bv::hide::modal', 'modal-1', '#btnShow')
            },
            /**
             * set current template
             *
             * @param selectedData
             */
            setCurrentTemplate(selectedData) {
                store.commit('SET_CURRENT_TEMPLATE', selectedData);
            },
            /**
             * Get current btemplate
             *
             * @returns {*}
             */
            getCurrentTemplate() {
                return store.state.getCurrentTemplate;
            },

        },
        computed:
            {

            },
        beforeMount() {
            this.columnDefs = [
                {headerName: 'ID', field: 'id', sortable: true, filter: true, checkboxSelection: true},
                {headerName: 'Name', field: 'name', sortable: true, filter: true},
                {headerName: 'User Name', field: 'user.name', sortable: true, filter: true},
                {headerName: 'Project Name', field: 'project.name', sortable: true, filter: true},
                {headerName: 'File Type', field: 'file_path', sortable: true, filter: true},
                {headerName: 'File Path', field: 'file_type', sortable: true, filter: true},
                {headerName: 'Is Active', field: 'is_active', sortable: true, filter: true},
                {headerName: 'Import Table', field: 'import_table', sortable: true, filter: true},
                {headerName: 'Export Table', field: 'export_table', sortable: true, filter: true},
                {headerName: 'Adapter Class', field: 'adapter_class', sortable: true, filter: true},
                {headerName: 'Created At', field: 'created_at', sortable: true, filter: true},
                {headerName: 'Updated At', field: 'updated_at', sortable: true, filter: true},
            ];


            fetch('/api/templates')
                .then(result => result.json())
                .then(rowData => this.rowData = rowData);
        }
    }
</script>