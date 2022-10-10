<template>
    <div>
        <addRole
            :showing="showAddModal"
            @close="showAddModal = false"
        ></addRole>
        <editRole
            :showing="showModal"
            :edit-role="editRole"
            @close="showModal = false"
        ></editRole>

        <section class="gradient-custom">
            <div class="border p-4  flex items-center justify-between">
                Roles
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-65">
                        <a @click.prevent = "addItem()" class="btn btn-sm btn-success text-white w-25 p-2 text-uppercase rounded mt-3">Add role</a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6 table-responsive mt-3">
                        <table class="table table-light table-striped rounded">
                            <thead class="table-dark ">
                            <tr>
                                <th class="border-top-left-radius col-1">#</th>
                                <th >Title</th>
                                <th class="border-top-right-radius col-1">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="role in getAllRoles" :key="role.id">
                                <td class="col-1">{{role.id}}</td>
                                <td class="col-4">{{role.title}}</td>
                                <td class="col-1 text-center">
                                    <a @click.prevent = "editItem(role.id)" class="btn btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a @click.prevent = "deleteRole(role.id)" class="btn btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
import editRole from './Edit.vue'
import addRole from './Add.vue'

export default {
    data() {
        return {
            showAddModal: false,
            showModal: false,
            editRole: {},
        }
    },
    components: {
        editRole,
        addRole
    },
    mounted(){
        this.$store.dispatch("getAllRoles");
    },
    computed:{
        getAllRoles(){
            return this.$store.getters.roles
        }
    },
    methods : {
        async deleteRole(id){
            if (confirm("Do you really want to delete?")) {
                try {
                    await this.$store.dispatch('deleteRole' , {'id' : id});
                }
                catch (e) {

                }
            }
        },
        editItem(id) {
             this.editRole = this.$store.getters.roleById(id)
             this.showModal = true
        },
        addItem() {
            this.showAddModal = true
        },
    },
}
</script>
