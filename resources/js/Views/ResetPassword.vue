<template>
    <div>
        <loading v-model:active="isLoading" :is-full-page="fullPage"/>
        <section class="gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center text-white">
                                <h2 class="fw-bold mb-5 text-uppercase">Reset password</h2>
                                <Form @submit="reset" :validation-schema="schema" ref="reset">
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

                                    <button class="btn btn-outline-light btn-lg px-5 mt-4 mb-4" type="submit">Reset</button>
                                </Form>
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
import Swal from "sweetalert2";
import router from "../router";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    props  : {
        token : {
            required : true
        },
        email : {
            required : true
        }
    },
    data() {
        return {
            password: '',
            confirm: '',
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
                password: yup.string().required().min(6),
                confirm: yup.string().oneOf([yup.ref('password'), null], 'Passwords must match').required().min(6),
            });
        },
    },
    methods: {
        async reset() {
            try {
                this.isLoading = true;
                await axios.post('/api/reset-password' , {
                    'email': this.email,
                    'token': this.token,
                    'password': this.password,
                    'password_confirmation': this.confirm
                })
                    .then((res) =>{
                        this.isLoading = false;
                        Swal.fire({
                            title: 'Ok',
                            text:  res.data.message,
                            icon: 'success',
                        }).then(function() {
                            router.push({name:'login'})
                        });
                    })
                    .catch((err) =>{
                        this.isLoading = true;
                        this.$refs.reset.setErrors(err.response.data.errors);
                    })
            } catch (e) {
                this.isLoading = true;
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
