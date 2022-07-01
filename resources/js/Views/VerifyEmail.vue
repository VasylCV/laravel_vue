<template>
    <loading v-model:active="isLoading"
             :is-full-page="fullPage"/>
    <section class="gradient-custom">
        <div class="border p-4  flex items-center justify-between">
            Email verification!
        </div>
    </section>
</template>


<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Swal from "sweetalert2";

export default {
    props  : {
        id : {
            required : true
        },
        hash : {
            required : true
        }
    },
    components: {
        Loading
    },
    data() {
        return {
            isLoading: true,
            fullPage: true,
            resend: false,
        }
    },
    methods : {
        async verify(){
            try {
                await this.$store.dispatch('verifyEmail' , {'id' : this.id , 'hash' : this.hash})
                    .then((res) =>{
                        this.isLoading = false;
                        setTimeout(()=>{
                            window.location = "/home";
                        },1000)
                    })
            } catch (e) {
                this.isLoading = false;
                Swal.fire({
                    title: 'OPPS',
                    text:  'Something went wrong, please try again later',
                    icon: 'error',
                }).then(function() {
                    window.location = "/home";
                });
            }
        },
    },
    mounted() {
        this.verify();
    },
}
</script>
