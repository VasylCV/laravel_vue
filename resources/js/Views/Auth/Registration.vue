<template>
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center text-white">
                            <h2 class="fw-bold mb-5 text-uppercase">Create an account</h2>
                            <Form @submit="register" :validation-schema="schema" ref="register">
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
                                <div class="form-floating mb-3 mt-3">
                                    <Field type="password"
                                           id="password"
                                           name="password"
                                           class="form-control"
                                           v-model="password"
                                           placeholder="Password"
                                    />
                                    <label for="password" class="text-black">Password</label>
                                    <ErrorMessage name="password" class="text-danger" />
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <Field type="password"
                                           id="confirm"
                                           name="confirm"
                                           class="form-control"
                                           v-model="confirm"
                                           placeholder="Confirm Password"
                                    />
                                    <label for="confirm" class="text-black">Confirm Password</label>
                                    <ErrorMessage name="confirm" class="text-danger" />
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5 mt-4 mb-4" type="submit">Register</button>
                            </Form>

                            <router-link :to="{name : 'login'}" class="pb-5 text-white"> Already a member ? Sing In ! </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Field, Form, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirm: '',
        }
    },
    components: {
        Field,
        Form,
        ErrorMessage
    },
    computed: {
        schema() {
            return yup.object({
                name: yup.string().required().min(3),
                email: yup.string().required().email(),
                password: yup.string().required().min(6),
                confirm: yup.string().oneOf([yup.ref('password'), null], 'Passwords must match').required().min(6),
            });
        },
    },
    methods: {
        async register() {
            try {
                await this.$store.dispatch('register' , {
                    'name' : this.name,
                    'email' : this.email ,
                    'password' : this.password ,
                    'password_confirmation' : this.confirm
                });
                this.$router.push({name: 'home'});
            } catch (e) {
                this.$refs.register.setErrors(e.data.errors);
            }
        }
    },
}
</script>
