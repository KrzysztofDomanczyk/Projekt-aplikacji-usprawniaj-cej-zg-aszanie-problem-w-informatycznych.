<template>

    <div class="card mb-4">
        <div class="card-header d-block d-flex" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">
                              <span style="text-align:left"> Task executors</span> <span class="d-block ml-auto green-color"><i class="fas fa-chevron-down"></i></span>
        </div>

        <div class="card-body collapse multi-collapse" id="multiCollapseExample1">
            <h5 class="card-title">Users: </h5>

            <button type="button" class="btn btn-outline-secondary d-block w-100 mb-3" data-toggle="modal"
                data-target="#exampleModal">
                + Add user
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add user</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" v-bind:class="[status == null ? 'd-none' : 'd-block']">
                                <div class="alert"
                                    v-bind:class="[status == 'success' ? 'alert-success' : 'alert-danger']"
                                    role="alert">
                                    {{message}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Email address</label>
                                <input type="email" class="form-control" v-model="user_add" id="exampleFormControlInput1"
                                    placeholder="name@example.com">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" v-on:click="addUser()" class="btn btn-outline-primary">Save changes</button>
                        </div>

                    </div>

                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" v-for="user in users" :key="user">
                    {{user}}
                    <button class="badge badge-danger badge-pill" v-on:click="deleteUser(user)">X</button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["ticketid"],
        mounted() {
            console.log('Component user mounted.')
            self = this;
           this.getUsers();
        },
        data: function () {
            return {
                user:null,
                user_add: null,
                status: null,
                message: "asds",
                users: null
            }
        },
        methods: {
            addUser: function (event) {
                self = this;
                console.log(event);
                axios.post('/api/ticket/add-user', {
                        user: this.user_add,
                        ticketid: this.ticketid
                    })
                    .then(function (response) {
                        self.status = response.data.status
                        self.message = response.data.msg
                        self.getUsers();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            deleteUser: function (event) {
                console.log(event);
                axios.post('/api/ticket/delete-user', {
                        user: event,
                        ticketid: this.ticketid
                    })
                    .then(function (response) {
                        console.log(response);
                        self.getUsers();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getUsers: function (event) {
            axios.get('/api/ticket/users-list/' + this.ticketid)
                .then(function (response) {
                    // handle success
                    console.log(response.data);
                    self.users = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            }
            
        }
    }
</script>
