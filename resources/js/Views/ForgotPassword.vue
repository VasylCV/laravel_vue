<template>
    <div>
        <loading v-model:active="isLoading" :is-full-page="fullPage"/>
        <section class="gradient-custom">
            <div class="container py-5 h-100 mt-4">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <h3 class="fw-bold mb-2 text-uppercase">Forgot your password?</h3>
                                <p class="text-white-50 mb-5">Please enter your email!</p>
                                <Form @submit="send" :validation-schema="schema" ref="form">
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
                                    <button class="btn btn-outline-light btn-lg px-5 mt-4 mb-4" type="submit">Send email</button>
                                </Form>
                                <router-link :to="{name : 'login'}" class="pb-5 text-white"> go back ? </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { Field, Form, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';
import Swal from 'sweetalert2';
import axios from "axios";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    data() {
        return {
            email: '',
            errors: '',
            isLoading: false,
            fullPage: true
        }
    },
    components: {
        Field,
        Form,
        ErrorMessage,
        Loading
    },
    computed: {
        schema() {
            return yup.object({
                email: yup.string().required().email(),
            });
        },
    },
    methods: {
        async send(){
            try {console.log(this.isLoading);
                this.isLoading = true;
                await axios.post('/api/forgot-password' , {'email': this.email}).then((res) => {
                    this.isLoading = false;
                    Swal.fire({
                        title: 'Ok',
                        text:  res.data.message,
                        icon: 'success',
                    }).then(function() {
                        window.location = "/";
                    });
                }).catch((err) => {
                    this.isLoading = false;
                    this.$refs.form.setErrors(err.response.data.errors);
                })
            } catch (e) {
                this.isLoading = false;
                Swal.fire({
                    title: 'OPPS',
                    text:  'Something went wrong, please try again later',
                    icon: 'error',
                });
            }
        }
    },
}
</script>
