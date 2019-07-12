<template>
    <v-dialog v-model="show"
              transition="dialog-bottom-transition">
        <v-card>
            <v-tabs
                    color="blue"
                    dark
                    slider-color="yellow">
                <v-tab ripple>
                    Base Data
                </v-tab>
                <v-tab ripple>
                    Mapping
                </v-tab>
                <v-tab-item>
                    <v-card-title v-if="currentTemplate">
                        <h2>Edit Template "{{currentTemplate.name}}"</h2>
                    </v-card-title>

                    <v-card-text>
                        <v-divider/>
                        <v-flex xs12 sm6 md3 v-if="currentTemplate">
                            <v-list-tile avatar @click="toggleIsActive()">
                                <v-list-tile-action>
                                    <v-checkbox v-model="currentTemplate.is_active" @click.prevent=""></v-checkbox>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>Is Active</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-flex>

                        <v-divider/>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-if="currentTemplate"
                                          label="Name *"
                                          placeholder="The name of the template"
                                          v-model="currentTemplate.name"
                            ></v-text-field>
                        </v-flex>
                        <v-divider/>
                        <v-flex v-if="currentTemplate" xs12 sm6 md3
                                class="text-xs-center text-sm-center text-md-center text-lg-center">
                            <v-text-field label="Select ImportFile" @click='pickFile'
                                          v-model='currentTemplate.file_path'></v-text-field>
                            <input
                                    type="file"
                                    style="display: none"
                                    ref="file"
                                    accept="text/csv"
                                    @change="onFilePicked"
                            >
                        </v-flex>
                        <v-divider/>
                        <v-flex xs12 sm6 md3>
                            <v-list-tile avatar @click="toggleDropExistingData()">
                                <v-list-tile-action>
                                    <v-checkbox v-model="dropExistingData" @click.prevent=""></v-checkbox>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>Drop existing data</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-flex>
                        <v-divider/>
                    </v-card-text>
                </v-tab-item>

                <!-- Tab Mapping -->
                <v-tab-item style="padding: 10px">
                    <v-tabs
                            color="orange"
                            dark
                            slider-color="yellow">
                        <v-tab ripple>
                            Conditional mapping
                        </v-tab>
                        <v-tab ripple>
                            Simple mapping
                        </v-tab>
                        <v-tab-item>
                            <v-card-title>
                                <h2 v-if="currentImportTable.length && currentTemplate">Edit Column Mapping of table:"{{currentTemplate.import_table}}"</h2>
                                <h2 v-else>No Datafile found. Please upload a datafile under "Basedata"</h2>
                            </v-card-title>
                            <v-container fluid>
                                <v-flex xs12>
                                    <v-btn color="blue" outline @click="addCondition()">Add Condition</v-btn>
                                    <v-layout row xs12 wrap>
                                        <v-flex xs2 md2 lg3 style="margin: 5px">
                                            <div v-if="conditions" v-for="(column,key) in conditions">
                                                <v-select
                                                        :items="column.sourceColumns"
                                                        label="source"
                                                        v-model="selectedConditions.definition.sourceColumns"
                                                ></v-select>
                                            </div>
                                        </v-flex>
                                        <v-flex xs1 md1 lg1 style="margin: 5px">
                                            <div v-if="conditions" v-for="(column,key) in conditions">
                                                <v-select
                                                        :items="column.operators"
                                                        label="operators"
                                                        v-model="selectedConditions.definition.targetColumns[key]"
                                                ></v-select>
                                            </div>
                                        </v-flex>
                                        <v-flex xs2 md3 lg3 style="margin: 5px">
                                            <div v-if="conditions" v-for="(column,key) in conditions">
                                                <v-select
                                                        :items="column.targetColumns"
                                                        label="target"
                                                        v-model="selectedConditions.definition.operators[key]"
                                                ></v-select>
                                            </div>
                                        </v-flex>
                                        <v-flex xs2 md1 lg1 style="margin: 5px">
                                            <div v-if="conditions" v-for="(column,key) in conditions">
                                                <v-select
                                                        :items="['or']"
                                                        label="or"
                                                ></v-select>
                                            </div>
                                        </v-flex>
                                        <v-flex xs1 md1 lg1 style="margin: 5px">
                                            <div v-if="conditions" v-for="(column,key) in conditions">
                                                <v-text-field
                                                        small label="Freetext"
                                                        v-model="selectedConditions.freetext[key]"
                                                ></v-text-field>
                                            </div>
                                        </v-flex>
                                        <v-flex xs2 md3 lg1 style="margin: 5px">
                                            <div v-if="conditions" v-for="(item,index) in conditions"
                                                 style="margin:10px 0 0 0;height30px;pading:0;">
                                                <v-btn style="margin:0px 0 30px 0" color="blue" outline
                                                       @click="deleteCondition(index)">Delete
                                                </v-btn>
                                            </div>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-container>
                        </v-tab-item>
                        <v-tab-item style="padding: 10px">
                            <v-card-title>
                                <h2>Simple mappings"</h2>
                            </v-card-title>
                            <v-container fluid>
                                <v-flex xs12>
                                    <v-btn color="blue" outline @click="addSimpleMappings()">Add simple mapping</v-btn>
                                    <v-layout row xs12 wrap>
                                        <v-flex xs2 md2 lg3 style="margin: 5px">


                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-container>
                        </v-tab-item>
                        <v-card-actions>
                            <v-btn color="primary" outline @click="saveConditions()">Save conditions</v-btn>
                        </v-card-actions>
                    </v-tabs>
                </v-tab-item>
                <v-card-actions>
                    <v-btn color="primary" outline @click.stop="show=false">Close</v-btn>
                    <v-btn color="primary" outline @click="saveTemplate()">Save</v-btn>
                </v-card-actions>
            </v-tabs>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        props: {
            value: Boolean
        },

        data() {
            return {
                select: ['sdasdsa', 'sadasd'],
                importUrl: '',
                dropExistingData: false,
            }
        },

        computed: {
            ...mapState(['currentTemplate', 'pagination', 'items', 'templates', 'databaseTables', 'currentImportTable','selectedConditions']),
            show: {
                get() {
                    return this.value
                },
                set(value) {
                    this.$emit('input', value)
                }
            },

            operators: {
                get() {
                    return ['=', '<=', '<', '>', '>=']
                },
                set(value) {
                    this.$emit('input', value)
                }
            },
            conditions: {

                get()
                {
                    return this.$store.getters.conditions;
                },
                set(value) {
                    this.conditions = value;
                },
            },

        },

        methods: {

            /**
             * Save conditions
             */
            saveConditions() {

                alert("111");
                console.log("----------------------------------");
                console.log(this.selectedConditions.definition);

                this.$store.dispatch('saveConditions', this.selectedConditions)
            },

            /**
             * delete condition
             */
            deleteCondition(_index) {
                let conditions = this.conditions.filter(function (value, index) {
                    return index !== _index;
                });

                this.$store.dispatch("setConditions", conditions);
            },
            /**
             * Add conditions
             */
            addCondition() {


                this.conditions.push({
                    'sourceColumns': this.$store.getters.currentImportTable,
                    operators: this.operators,
                    'targetColumns': this.$store.getters.currentImportTable,
                    'freetext': 'test'
                });

                console.log(this.conditions);


                this.$store.dispatch("setConditions", this.conditions);
            },
            /**
             * Toggles is_active
             */
            toggleIsActive() {

                this.currentTemplate.is_active = !this.currentTemplate.is_active;
            },


            /**
             * Picks file
             */
            pickFile() {
                this.$refs.file.click()
            },

            /**
             * Toggles drop existing data
             */
            toggleDropExistingData() {
                this.dropExistingData = !this.dropExistingData
            },

            /**
             * When file was picked
             */
            onFilePicked(e) {
                const files = e.target.files;

                if (files[0] !== undefined) {
                    this.fileName = files[0].name;
                    if (this.fileName.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader()
                    fr.readAsDataURL(files[0]);
                    fr.addEventListener('load', () => {

                        this.currentTemplate.file_path = files[0].name;
                        this.currentTemplate.file = files[0];

                    })
                } else {
                    this.fileName = '';
                }
            },

            /**
             * Upload file
             */
            upload() {

                var self = this;

                let formData = new FormData();

                if (typeof this.currentTemplate.file === "undefined") {
                    return;
                }

                formData.append('file', this.currentTemplate.file);

                return new Promise((resolve, reject) => {

                    axios.post('/api/templates/' + this.currentTemplate.id + '/upload',

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

                        reject(error.response.data);

                        alert('FAILURE Uploading');
                    });
                });
            },

            /**
             * Process UploadedFile
             */
            processUploadedFile() {
                return new Promise((resolve, reject) => {
                    axios.post('/api/templates/' + this.currentTemplate.id + '/processUploadedFile?dropExistingData=' + this.dropExistingData,
                        this.currentTemplate
                    ).then(response => {

                        this.$store.dispatch('queryItems');

                        resolve(response);

                    }).catch(function (error) {

                        reject(error.response.data);

                        alert('FAILURE Processing Uploaded file');
                    });
                });
            },


            /**
             * Save template
             *
             * @returns {Promise<any>}
             */
            saveTemplate() {

                return new Promise((resolve, reject) => {

                    axios.put('/api/templates/' + this.currentTemplate.id, this.currentTemplate)

                        .then(response => {
                            resolve(response);

                            this.upload();

                            this.show = false
                        })
                        .catch(error => {
                            reject(error.response.data)
                        })
                });
            }
        },
    }
</script>