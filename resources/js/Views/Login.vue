<template>
    <section class="gradient-custom">
        <div class="container py-5 h-100 mt-4">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="text-white-50 mb-5">Please enter your login and password!</p>
                            <Form @submit="login" :validation-schema="schema" ref="login">
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

                                <button class="btn btn-outline-light btn-lg px-5 mt-4 mb-4" type="submit">Login</button>
                            </Form>
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
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            email: '',
            password: '',
            errors: '',
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
                email: yup.string().required().email(),
                password: yup.string().required().min(6),
            });
        },
    },
    methods: {
        async login(){
            try {
                await this.$store.dispatch('login' , {'email' : this.email , 'password' : this.password});

                this.$router.push({name: 'home'});
            }
            catch (e){
                if (e.data.success === false) {
                    Swal.fire({
                        title: 'OPPS',
                        text:  e.data.message,
                        icon: 'error',
                    });
                } else {
                    this.$refs.login.setErrors(e.data.errors);
                }
            }
        }
    },
}
</script>
