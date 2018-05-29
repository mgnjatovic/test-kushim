<template>
    <div>
        <div class="alert alert-success" v-if="saved">
            <strong>Success!</strong> Your group has been saved successfully.
        </div>
        <div class="card">
            <div v-show="!exists" class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-lg btn-secondary" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true"
                            aria-controls="collapseOne">
                        New group
                    </button>
                </h5>
            </div>
            <div id="collapseOne" :class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="well well-sm" id="group-form">
                        <form class="form-horizontal" method="post" @submit.prevent="onSubmit">
                            <fieldset>
                                <legend v-show="exists" class="text-center">Rename group</legend>
                                <div class="form-group d-block">
                                    <div class="col-md-12" :class="{'has-error': errors.name}">
                                        <input id="name"
                                               v-model="group.name"
                                               type="text"
                                               placeholder="Group name"
                                               class="form-control">
                                        <span v-if="errors.name" class="help-block text-danger">{{ errors.name[0]
                                            }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-secondary btn-md">Submit</button>
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
    export default {
        props: ['group-id'],
        created() {
            if (this.groupId)
                this.fetch();
        },
        data(){
            return {
                errors: [],
                saved: false,
                group: {
                    id: this.groupId ? this.groupId : null,
                    name: null,
                },
                endpoint: this.groupId ? '/api/groups/' + this.groupId : null,
                exists: this.groupId ? true : false,
                collapse: !this.groupId ? 'collapse hide' : 'collapse show'
            };
        },

        methods: {
            fetch() {
                axios.get(this.endpoint)
                    .then(({data}) => {
                        this.group = data.data;
                    });
            },
            onSubmit() {
                this.saved = false;
                axios.post('/api/groups', this.group)
                    .then(({data}) => this.setSuccessMessage())
                    .catch(({response}) => this.setErrors(response));
            },

            setErrors(response) {
                this.errors = response.data.errors;
            },

            setSuccessMessage() {
                this.reset();
                this.saved = true;
                //TODO: make this work without reload
                location.reload();
            },

            reset() {
                this.errors = [];
            }
        }
    }
</script>