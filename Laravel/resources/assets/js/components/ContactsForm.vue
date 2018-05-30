<template>
    <div>
        <div class="alert alert-success" v-if="saved">
            <strong>Success!</strong> Your contact has been saved successfully.
        </div>

        <div class="alert alert-danger" v-if="errors">
            <strong>Error!</strong> Your contact has not been saved successfully. {{errors}}
        </div>

        <div class="card">
            <div v-show="!exists" class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-lg btn-secondary" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true"
                            aria-controls="collapseOne">
                        New contact
                    </button>
                </h5>
            </div>
            <div id="collapseOne" :class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="well well-sm" id="contact-form">
                        <form class="form-horizontal" method="post" @submit.prevent="onSubmit">
                            <fieldset>
                                <legend v-show="!exists" class="text-center">Add new contact</legend>
                                <legend v-show="exists" class="text-center">Edit contact</legend>
                                <img :src="contact.avatar" class="rounded-circle m-2 pull-right" height="100"
                                     width="100">
                                <div class="form-contact d-block">


                                    <input type="file" v-on:change="onImageChange" class="form-control">

                                    <input id="first_name" v-model="contact.first_name" type="text"
                                           placeholder="First name"
                                           class="form-control">
                                    <span v-if="errors.first_name"
                                          class="help-block text-danger">{{ errors.first_name[0]
                                        }}</span>
                                    <input id="last_name" v-model="contact.last_name" type="text"
                                           placeholder="Last name"
                                           class="form-control">
                                    <span v-if="errors.last_name"
                                          class="help-block text-danger">{{ errors.last_name[0]
                                        }}</span>
                                    <input id="address" v-model="contact.address" type="text" placeholder="Address"
                                           class="form-control">
                                    <span v-if="errors.last_name"
                                          class="help-block text-danger">{{ errors.address[0] }}</span>
                                    <input id="city" v-model="contact.city" type="text" placeholder="City"
                                           class="form-control">
                                    <span v-if="errors.city" class="help-block text-danger">{{ errors.city[0]
                                        }}</span>
                                    <input id="zip" v-model="contact.zip" type="text" placeholder="Zip"
                                           class="form-control">
                                    <span v-if="errors.zip" class="help-block text-danger">{{ errors.zip[0]
                                        }}</span>
                                    <input id="country" v-model="contact.country" type="text" placeholder="Country"
                                           class="form-control">
                                    <span v-if="errors.country" class="help-block text-danger">{{ errors.country[0]
                                        }}</span>
                                    <input id="email" v-model="contact.email" type="text" placeholder="Email"
                                           class="form-control">
                                    <span v-if="errors.country" class="help-block text-danger">{{ errors.country[0]
                                        }}</span>
                                    <input id="phone" v-model="contact.phone" type="text" placeholder="phone"
                                           class="form-control">
                                    <input id="note" v-model="contact.note" type="text" placeholder="note"
                                           class="form-control">
                                    <div>
                                        <label class="typo__label">Select groups</label>
                                        <multiselect
                                                v-model="contact.groups"
                                                :selected="contact.groups"
                                                :options="groups"
                                                :multiple="true"
                                                placeholder="Select group"
                                                label="name"
                                                track-by="name"
                                                :taggable="true">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="form-contact">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-secondary btn-lg">Submit</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        props: ['contact-id', 'group-id'],
        components: {Multiselect},
        created() {
            this.fetchGroups();

            if (this.contactId)
                this.fetch();
        },
        data(){
            return {
                errors: false,
                saved: false,
                contact: {
                    id: this.contactId ? this.contactId : null,
                    avatar: null,
                    first_name: null,
                    address: null,
                    city: null,
                    zip: null,
                    country: null,
                    phone: null,
                    groups: null,
                    note: null,
                },
                groups: [],
                endpoint: this.contactId ? '/api/contacts/' + this.contactId : null,
                exists: this.contactId,
                collapse: !this.contactId ? 'collapse hide' : 'collapse show',
                image: ''
            };
        },
        methods: {
            fetch() {
                axios.get(this.endpoint)
                    .then(({data}) => {
                        this.contact = data.data;
                    });
            },
            fetchGroups() {
                axios.get('/api/groups')
                    .then(({data}) => {
                        this.groups = data.data;
                    });
            },
            onSubmit() {
                this.saved = false;
                axios.post('/api/contacts', this.contact)
                    .then((response) => this.setSuccessMessage())
                    .catch((response) => {
                        this.setErrors(response)
                    });
            },

            setErrors(response) {
                if (typeof response.data.message == "undefined" || response.data.message == null) {
                    this.errors = response.data.message;
                }
                else {
                    this.errors = response;
                }
            },

            setSuccessMessage() {
                this.reset();
                this.saved = true;
                //TODO: make this work without reload
                //location.reload();
            },

            reset() {
                this.errors = false;
            },

            //-------------------Image upload

            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.contact.avatar = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>