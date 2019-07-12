let state = {
    currentTemplate:null,
    currentImportTable:[],
    selectedConditions:{
        template_id:null,
        created_at:null,
        updated_at:null,
        definition:
        {
            sourceColumns:[],
            targetColumns:[],
            operators:[],
            freetext:[]
        },
    },
    databaseTables:[],
    conditions:[],
    pagination: {
        descending: true,
        page: 1,
        rowsPerPage: 20,
        sortBy: 'id',
        totalItems: 0,
        rowsPerPageItems: [1, 2, 4, 8, 16],
    },
    items: []
};
export default  state