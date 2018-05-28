<template>
    <div>
        <div class="alert alert-success" v-if="saved">
            <strong>Success!</strong> Your contact has been saved successfully.
        </div>

        <div class="well well-sm" id="contact-form">
            <form class="form-horizontal" method="post" @submit.prevent="onSubmit">
                <fieldset>
                    <legend v-show="!exists" class="text-center">Add new contact</legend>
                    <legend v-show="exists" class="text-center">Edit contact</legend>
                    <div class="form-contact d-block">
                        <div class="col-md-12" :class="{'has-error': errors.name}">
                            <input id="avatar" v-model="contact.avatar" type="text" placeholder="Avatar"
                                   class="form-control">
                            <span v-if="errors.first_name" class="help-block text-danger">{{ errors.first_name[0]
                                }}</span>
                            <input id="first_name" v-model="contact.first_name" type="text" placeholder="First name"
                                   class="form-control">
                            <span v-if="errors.first_name" class="help-block text-danger">{{ errors.first_name[0]
                                }}</span>
                            <input id="last_name" v-model="contact.last_name" type="text" placeholder="Last name"
                                   class="form-control">
                            <span v-if="errors.last_name" class="help-block text-danger">{{ errors.last_name[0]
                                }}</span>
                            <input id="address" v-model="contact.address" type="text" placeholder="Address"
                                   class="form-control">
                            <span v-if="errors.last_name" class="help-block text-danger">{{ errors.address[0] }}</span>
                            <input id="city" v-model="contact.city" type="text" placeholder="City" class="form-control">
                            <span v-if="errors.city" class="help-block text-danger">{{ errors.city[0] }}</span>
                            <input id="zip" v-model="contact.zip" type="text" placeholder="Zip" class="form-control">
                            <span v-if="errors.zip" class="help-block text-danger">{{ errors.zip[0] }}</span>
                            <input id="country" v-model="contact.country" type="text" placeholder="Country"
                                   class="form-control">
                            <span v-if="errors.country" class="help-block text-danger">{{ errors.country[0] }}</span>
                            <input id="email" v-model="contact.email" type="text" placeholder="Email"
                                   class="form-control">
                            <span v-if="errors.country" class="help-block text-danger">{{ errors.country[0] }}</span>
                            <input id="phone" v-model="contact.phone" type="text" placeholder="phone"
                                   class="form-control">
                            <input id="note" v-model="contact.note" type="text" placeholder="note" class="form-control">
                            <span>Selected: {{ selected }}</span>
                            <select v-model="selected" multiple class="form-control">
                                <option v-for="group in contact.groups" v-bind:value="group.id">
                                    {{ group.name }}
                                </option>
                            </select>

                        </div>
                    </div>
                    <div class="form-contact">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['contact-id'],
        created() {
            if (this.contactId)
                this.fetch();
        },
        computed: {
            selected: function() {
                return [8,30];
            }
        },
        data(){
            return {
                errors: [],
                saved: false,
                contact: {
                    id: this.contactId ? this.contactId : null,
                    first_name: null,
                    address: null,
                    city: null,
                    zip: null,
                    country: null,
                    phone: null,
                    note: null,
                    groups: null,
                    selected: null
                },
                endpoint: this.contactId ? '/api/contacts/' + this.contactId : null,
                exists: this.contactId
            };
        },
        methods: {
            fetch() {
                axios.get(this.endpoint)
                    .then(({data}) => {
                        this.contact = data.data;
                    });
            },
            onSubmit() {
                this.saved = false;
                console.log(this.contact);
                axios.post('/api/contacts', this.contact)
                    .then(({data}) => this.setSuccessMessage())
                    .catch(({response}) => this.setErrors(response));
            },

            setErrors(response) {
                this.errors = response.data.errors;
            },

            setSuccessMessage() {
                this.reset();
                this.saved = true;
            },
        }
    }
</script>