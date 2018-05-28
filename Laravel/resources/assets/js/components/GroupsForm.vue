<template>
    <div>
        <div class="alert alert-success" v-if="saved">
            <strong>Success!</strong> Your group has been saved successfully.
        </div>

        <div class="well well-sm" id="group-form">
            <form class="form-horizontal" method="post" @submit.prevent="onSubmit">
                <fieldset>
                    <legend v-show="!exists" class="text-center">Add new group</legend>
                    <legend v-show="exists" class="text-center">Edit group</legend>

                    <div class="form-group d-block">
                        <div class="col-md-12" :class="{'has-error': errors.name}">
                            <input id="name"
                                   v-model="group.name"
                                   type="text"
                                   placeholder="Group name"
                                   class="form-control">
                            <span v-if="errors.name" class="help-block text-danger">{{ errors.name[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
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
                exists: this.groupId
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
                console.log(this.group);
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
            },

            reset() {
                this.errors = [];
                this.group = {name: null};
            }
        }
    }
</script>