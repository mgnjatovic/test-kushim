<template>
    <div>

        <div class="col-md-12 flex-center m-3">
            <a v-bind:href="'/contact/create'" class="btn btn-lg btn-secondary active pull-right">add new contact</a>
        </div>
        <div v-if="contacts.length > 0">
            <div v-for="contacts in groupedContacts" class="row">
                <div v-for="contact in contacts" class="col-lg-3">
                    <div class="card m-1 shadow ">
                        <div class="card-header">
                            <h4>
                                <a v-bind:href="'/contact/' + contact.id">{{contact.first_name}} {{contact.last_name}}</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <p>{{contact.address}}</p>
                            <p>{{contact.city}}</p>
                            <p>{{contact.zip}}</p>
                            <p>{{contact.country}}</p>
                            <p>{{contact.email}}</p>
                            <p>{{contact.phone}}</p>
                            <p>{{contact.note}}</p>
                            <p class="btn-sm btn-secondary" v-for="group in contact.groups"> {{ group.name }}</p>
                        </div>
                        <div class="card-footer text-right">
                            <a href="#" @click="remove(contact.id)">delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 flex-center m-3" v-else>
            <h1>No contacts in group</h1>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['group-id'],
        data() {
            console.log(this.groupId);
            return {
                contacts: [],
                endpoint: this.groupId ? '/api/group/' + this.groupId + '/contacts/' : 'api/contacts',
            };
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint)
                    .then(({data}) => {
                        this.contacts = data.data;
                        //this.pageCount = data.meta.last_page;
                    });
            },

            remove(id) {
                if (confirm('Are you sure you want to remove this contact?')) {
                    axios.get('api/contacts/' + id + '/remove')
                        .then(response => this.removeContact(id));
                }
            },

            removeContact(id) {
                this.contacts = _.remove(this.contacts, function (contact) {
                    return contact.id !== id;
                });
            }
        },

        computed: {
            groupedContacts() {
                return _.chunk(this.contacts, 4)
            }
        }
    }
</script>