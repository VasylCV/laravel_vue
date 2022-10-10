<template>
    <div v-if="showing" @click.self="close" class="modal show d-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add Role</h4>
                    <button type="button" class="btn-close" @click.prevent="close"></button>
                </div>

                <div class="modal-body">
                    <Form @submit="create" :validation-schema="schema" ref="create">
                        <div class="form-floating mb-3 mt-3">
                            <Field type="text"
                                   id="title"
                                   name="title"
                                   class="form-control"
                                   v-model="title"
                                   placeholder="Title"
                                   ref="title"
                            />
                            <label for="Title" class="text-black">Title</label>
                            <ErrorMessage name="title" class="text-danger" />
                        </div>

                        <button type="submit" class="btn btn-success">Create</button>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { Field, Form, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';

export default {
    props: {
        showing: {
            required: true,
            type: Boolean,
        },
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
            title: '',
        }
    },
    methods: {
        async create(){
            try {
                await this.$store.dispatch('createRole' , {
                    'title' : this.title,
                });

                this.$emit('close');
            }
            catch (e){
                this.$refs.create.setErrors(e.data.errors);
            }
        },
        close() {
            this.$emit('close');
        },
    },
}
</script>
