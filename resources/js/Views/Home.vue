<template>
    <section class="gradient-custom">
        <div class="border p-4  flex items-center justify-between">
            Home
        </div>

        <div class="p-4 col-4">
            <Form @submit="update" :validation-schema="schema" ref="update">
                <div class="form-floating mb-3 mt-3">
                    <Field type="text"
                           id="name"
                           name="name"
                           class="form-control"
                           v-model="name"
                           placeholder="Your Name"
                    />
                    <label for="name" class="text-black">Your Name</label>
                    <ErrorMessage name="name" class="text-danger" />
                </div>
                <div class="form-floating mb-3 mt-3">
                    <Field type="email"
                           id="email"
                           name="email"
                           class="form-control"
                           v-model="email"
                           placeholder="Your email"
                    />
                    <label for="email" class="text-black">Your Email</label>
                    <ErrorMessage name="email" class="text-danger" />
                </div>

                <button type="submit" class="btn btn-success">Update</button>
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
            email:'',
            name:'',
            id:'',
        }
    },
    components: {
        Field,
        Form,
        ErrorMessage
    },
    computed : {
        user() {
            return this.$store.getters.user
        },
        schema() {
            return yup.object({
                name: yup.string().required().min(3),
                email: yup.string().required().email(),
            });
        },
    },
    methods : {
        async update(){
            try {
                await this.$store.dispatch('updateUser' , {'email' : this.email , 'name' : this.name});
            }
            catch (e){
                this.$refs.update.setErrors(e.data.errors);
            }
        },
    },
    mounted() {
        this.name = this.user.name
        this.email = this.user.email
    },
}
</script>
