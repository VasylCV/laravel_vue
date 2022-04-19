<template>
    Hello
</template>

<script>
import { Field, Form, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            appUrl: process.env.MIX_APP_URL,
            data: {},
            isValid: true,
            errors: '',
        }
    },
    components: {
        Field,
        Form,
        ErrorMessage
    },
    methods: {
        login() {
            axios
                .post(this.appUrl + '/api/login', this.data)
                .then(response => {
                    console.log(response.data);

                    Swal.fire({
                        title: 'Hello!',
                        text:   response.data.message,
                        icon: 'success',
                    });
                })
                .catch(error => Swal.fire({
                    title: 'OPPS',
                    text:  'These credentials do not match our records.',
                    icon: 'error',
                }))
                .finally(() => this.loading = false)
        },
    },
    computed: {
        schema() {
            return yup.object({
                email: yup.string().required().email(),
                password: yup.string().required().min(3),
            });
        },
    },
}
</script>
