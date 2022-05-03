<template>
    <div v-if="showing" @click.self="close" class="modal show d-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Edit Article</h4>
                    <button type="button" class="btn-close" @click.prevent="close"></button>
                </div>

                <div class="modal-body">
                    <Form @submit="update" :validation-schema="schema" ref="update">
                        <div class="form-floating mb-3 mt-3">
                            <Field type="text"
                                   id="title"
                                   name="title"
                                   class="form-control"
                                   :value="editArticle.title"
                                   placeholder="Title"
                                   ref="title"
                            />
                            <label for="Title" class="text-black">Title</label>
                            <ErrorMessage name="title" class="text-danger" />
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <Field as="textarea"
                                   rows="5"
                                   id="text"
                                   name="text"
                                   class="form-control"
                                   :value="editArticle.text"
                                   placeholder="Text"
                                   ref="text"
                            />
                            <label for="text" class="text-black">Text</label>
                            <ErrorMessage name="text" class="text-danger" />
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
        editArticle: {},
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
                text: yup.string().required().min(8),
            });
        },
    },
    data() {
        return {
        }
    },
    setup () {
        const title = ref(null);

        const text = ref(null);

        return {
            title,
            text
        }
    },
    methods: {
        async update(){
            try {
                await this.$store.dispatch('updateArticle' , {'id' : this.editArticle.id,
                                                              'title' : title.value ,
                                                              'text' : text.value});
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
