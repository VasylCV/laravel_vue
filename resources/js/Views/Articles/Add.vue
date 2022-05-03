<template>
    <section class="gradient-custom">
        <div class="border p-4  flex items-center justify-between">
            Create New Article
        </div>

        <div class="p-4 col-4">
            <Form @submit="create" :validation-schema="schema" ref="create">
                <div class="form-floating mb-3 mt-3">
                    <Field type="text"
                           id="title"
                           name="title"
                           class="form-control"
                           v-model="title"
                           placeholder="Title"
                    />
                    <label for="Title" class="text-black">Title</label>
                    <ErrorMessage name="title" class="text-danger" />
                </div>
                <div class="form-floating mb-3 mt-3">
                    <Field as="textarea"
                           rows="7"
                           id="text"
                           name="text"
                           class="form-control"
                           v-model="text"
                           placeholder="Text"
                    />
                    <label for="text" class="text-black">Text</label>
                    <ErrorMessage name="text" class="text-danger" />
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </Form>
        </div>
    </section>
</template>


<script>
import { Field, Form, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';

export default {
    data() {
        return {
            title: '',
            text: '',
        }
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
    methods : {
        async create(){
            try {
                await this.$store.dispatch('addArticle' , {
                    'title' : this.title,
                    'text' : this.text,
                });

                this.$router.push({name: 'articles'});
            }
            catch (e){
                this.$refs.create.setErrors(e.data.errors);
            }
        },
    },
}
</script>
