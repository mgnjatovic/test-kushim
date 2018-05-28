<template>
    <div>
        <div class="col-md-12 flex-center m-3">
            <a v-bind:href="'/group/create'" class="btn btn-lg btn-secondary active pull-right">add new group</a>
        </div>
        <div class="col-md-12 m-1">
            <div v-for="groups in groupedGroups" class="row">
                <div v-for="group in groups" class="col-md">
                    <div class="card m-1 shadow">
                        <div class="card-body">
                            <h4><a v-bind:href="'/group/'+ group.id">{{group.name}}</a></h4>
                        </div>
                        <div class="card-footer text-right">
                            <a class="mr-2" href="#" @click="remove(group.id)"> delete </a>
                            <a v-bind:href="'/group/'+ group.id+'/edit'"> rename </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                groups: [],
                endpoint: 'api/groups'
            };
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint)
                    .then(({data}) => {
                        this.groups = data.data;
                    });
            },

            remove(id) {
                if (confirm('Are you sure you want to remove this group?')) {
                    axios.get('api/groups/' + id + '/remove')
                        .then(response => this.removeGroup(id));
                }
            },

            removeGroup(id) {
                this.groups = _.remove(this.groups, function (group) {
                    return group.id !== id;
                });
            }
        },

        computed: {
            groupedGroups() {
                return _.chunk(this.groups, 3)
            }
        }
    }
</script>