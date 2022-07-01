<template>
    <div>
        <loading v-model:active="isLoading" :is-full-page="fullPage"/>
        <section class="gradient-custom">
            <div class="border p-4  flex items-center justify-between">
                Home
            </div>

            <div class="p-4 col-4 text-uppercase text-white">
                <div v-if="isVerified !== false">
                    <div class="alert alert-success" role="alert">
                        Account verified
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-danger" role="alert">
                        This account has not been verified, please click <a href="#" class="alert-link" @click="resend()">here</a> for receiving verification email.
                    </div>
                </div>
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
    </div>
</template>


<script>
import { Field, Form, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Swal from "sweetalert2";

export default {
    data() {
        return {
            isVerified: false,
            email:'',
            name:'',
            id:'',
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
    computed : {
        user() {
            return this.$store.getters.user;
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
                this.isLoading = true;
                await this.$store.dispatch('updateUser' , {'email' : this.email , 'name' : this.name});
                this.isLoading = false;
            }
            catch (e){
                this.$refs.update.setErrors(e.data.errors);
            }
        },
        async resend(){
            try {
                this.isLoading = true;
                await this.$store.dispatch('verifyResend' , {'id' : this.id});
                this.isLoading = false;
            } catch (e) {
                Swal.fire({
                    title: 'OPPS',
                    text:  'Something went wrong, please try again later',
                    icon: 'error',
                });
            }

        }
    },
    mounted() {
        this.id = this.user.id;
        this.name = this.user.name;
        this.email = this.user.email;
        this.isVerified = (this.user.email_verified_at !== null);
    },
}
</script>
