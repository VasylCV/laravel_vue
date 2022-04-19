<template>
    <div class="container">
        <div class="p-5 mt-4 rounded-3">
            <h1 class="display-5 fw-bold text-center">Laravel & Vue.js example</h1>
            <div class="row">
                <div class="col-6"><img src="/images/laravel.png" class="img-fluid" /></div>
                <div class="col-6"><img src="/images/vuejs.png" class="img-fluid" /></div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            auth : true
        }
    },
    computed : {
        user() {
            return this.$store.getters.user ;
        }
    }
}
</script>
