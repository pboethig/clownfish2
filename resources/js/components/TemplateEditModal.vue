<template>
    <v-dialog v-model="show" max-width="80%"
              dark
              transition="dialog-bottom-transition"
              scrollable>
        <v-card>
            <v-card-title>
                Edit Template {{name}}
            </v-card-title>
            <!-- Snackbar -->
            <v-card-text>
                <v-flex xs12 sm6 md3>
                    <v-list-tile avatar @click="toggleIsActive()">
                        <v-list-tile-action>
                            <v-checkbox v-model="is_active" @click.prevent=""></v-checkbox>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Is Active</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-flex>

                <v-flex xs12 sm6 md3>
                    <v-text-field
                            label="Name *"
                            placeholder="The name of the template"
                            v-model="name"
                    ></v-text-field>
                </v-flex>
                <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
                    <v-text-field label="Select ImportFile" @click='pickFile' v-model='file_path' prepend-icon='attach_file'></v-text-field>
                    <input
                            type="file"
                            style="display: none"
                            ref="file"
                            accept="text/csv"
                            @change="onFilePicked"
                    >
                </v-flex>
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
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" @click.stop="show=false">Close</v-btn>
                <v-btn color="primary" @click="saveTemplate()">Save</v-btn>
            </v-card-actions>
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
                importUrl:'',
                dropExistingData:false,
            }
        },

        methods: {
            /**
             * Toggles is_active
             */
            toggleIsActive() {

                this.currentTemplate.is_active = !this.currentTemplate.is_active;
            },

            /**
             * Picks file
             */
            pickFile () {
                this.$refs.file.click ()
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
            onFilePicked (e) {
                const files = e.target.files;

                if(files[0] !== undefined) {
                    this.fileName = files[0].name;
                    if(this.fileName.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader ()
                    fr.readAsDataURL(files[0]);
                    fr.addEventListener('load', () => {

                        this.currentTemplate.file_path=files[0].name;
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

                if(typeof this.currentTemplate.file === "undefined")
                {
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
            processUploadedFile()
            {
                return new Promise((resolve, reject) =>
                {
                    axios.post('/api/templates/' + this.currentTemplate.id + '/processUploadedFile?dropExistingData='+this.dropExistingData,
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
            saveTemplate(){

                return new Promise((resolve, reject) => {

                    axios.put('/api/templates/' + this.currentTemplate.id, this.currentTemplate)

                        .then(response => {
                            resolve(response);

                            this.upload();

                            this.show=false
                        })
                        .catch(error => {
                            reject(error.response.data)
                        })
                });
            }
        },

        computed: {
            ...mapState(['currentTemplate', 'templates']),
            show: {
                get() {
                    return this.value
                },
                set(value) {
                    this.$emit('input', value)
                }
            },
            name: {
                get() {

                    if (this.currentTemplate) {
                        return this.currentTemplate.name;
                    }

                    return null;

                },
                set(value) {
                    this.currentTemplate.name = value;
                }
            },

            is_active: {
                get() {

                    if (this.currentTemplate) {
                        return this.currentTemplate.is_active;
                    }

                    return null;

                },
                set(value) {
                    this.currentTemplate.is_active = value;
                }
            },

            file_path: {
                get() {

                    if (this.currentTemplate) {
                        return this.currentTemplate.file_path;
                    }

                    return null;

                },
                set(value) {
                    this.currentTemplate.file_path = value;
                }
            },
        }
    }
</script>