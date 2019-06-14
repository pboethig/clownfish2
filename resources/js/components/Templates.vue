<template>
    <div>
        <TemplateEditModal2/>
        <b-button @click="getSelectedRows()">Get Selected Rows</b-button>
        <ag-grid-vue style="width: 100%; height: 500px;"
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
    export default {
        name: 'App',
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
            TemplateEditModal2
        },
        methods: {
            onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
            },
            getSelectedRows() {
                const selectedNodes = this.gridApi.getSelectedNodes();
                const selectedData = selectedNodes.map(node => node.data);

                const selectedDataStringPresentation = selectedData.map(node => node.id + ' ' + node.name).join(', ');
                //alert(`Selected nodes: ${selectedDataStringPresentation}`);

                this.showModal();

            },
            showModal() {
                this.$root.$emit('bv::show::modal', 'modal-1', '#btnShow')
            },
            hideModal() {
                this.$root.$emit('bv::hide::modal', 'modal-1', '#btnShow')
            },
            toggleModal() {
                this.$root.$emit('bv::toggle::modal', 'modal-1', '#btnToggle')
            }
        },
        beforeMount() {
            this.columnDefs = [
                {headerName: 'ID', field: 'id', sortable: true, filter: true, checkboxSelection: true},
                {headerName: 'Name', field: 'name', sortable: true, filter: true},
                {headerName: 'UserId', field: 'user_id', sortable: true, filter: true},
                {headerName: 'Project', field: 'project_id', sortable: true, filter: true, rowGroup: true},
                {headerName: 'Groups', field: 'groups'},
                {headerName: 'File Type', field: 'file_type', sortable: true, filter: true},
                {headerName: 'Is Active', field: 'is_active', sortable: true, filter: true},
                {headerName: 'Import Table', field: 'import_table', sortable: true, filter: true},
                {headerName: 'Export Table', field: 'export_table', sortable: true, filter: true},
                {headerName: 'Adapter Class', field: 'adapter_class', sortable: true, filter: true},
                {headerName: 'Created At', field: 'created_at', sortable: true, filter: true},
                {headerName: 'Updated At', field: 'updated_at', sortable: true, filter: true},
            ];

            this.autoGroupColumnDef = {
                headerName: 'Project',
                field: 'project_id',
                cellRenderer: 'agGroupCellRenderer',
                cellRendererParams: {
                    checkbox: true
                }
            };

            fetch('/api/templates')
                .then(result => result.json())
                .then(rowData => this.rowData = rowData);
        }
    }
</script>