<template>
    <div v-if="showing" @click.self="close" class="modal show d-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Edit Role</h4>
                    <button type="button" class="btn-close" @click.prevent="close"></button>
                </div>

                <div class="modal-body">
                    <Form @submit="update" :validation-schema="schema" ref="update">
                        <div class="form-floating mb-3 mt-3">
                            <Field type="text"
                                   id="title"
                                   name="title"
                                   class="form-control"
                                   :value="editRole.title"
                                   placeholder="Title"
                                   ref="title"
                            />
                            <label for="Title" class="text-black">Title</label>
                            <ErrorMessage name="title" class="text-danger" />
                        </div>

                        <button type="submit" class="btn btn-success">Save</button>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { Field, Form, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';
import { ref } from 'vue'

export default {
    props: {
        showing: {
            required: true,
            type: Boolean,
        },
        editRole: {},
    },
    components: {
        Field,
        Form,
        ErrorMessage
    },
    computed : {
        schema() {
            return yup.object({
                title: yup.string().required().min(3),
            });
        },
    },
    data() {
        return {
        }
    },
    setup () {
        const title = ref(null);

        return {
            title,
        }
    },
    methods: {
        async update(){
            try {
                await this.$store.dispatch('updateRole' , {'id' : this.editRole.id,
                                                           'title' : title.value });
                this.$emit('close');
            }
            catch (e){
                this.$refs.update.setErrors(e.data.errors);
            }
        },
        close() {
            this.$emit('close');
        },
    },
}
</script>
