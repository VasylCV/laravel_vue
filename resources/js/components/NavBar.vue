<template>
    <div class="container-fluid p-3 bg-dark text-white">
        <div class="d-flex flex-wrap align-items-center justify-content-end">
            <router-link class="link me-lg-auto mb-2 justify-content-start mb-md-0d-flex mb-2 mb-lg-0 text-white text-decoration-none" :to="{name : 'welcome'}">
                Laravel Vue
            </router-link>

            <div v-if="user" class="position-relative mx-5">
                <router-link class="link d-inline-flex items-center text-white text-decoration-none me-3" :to="{ name: 'articles' }">
                    ARTICLES
                </router-link>

                <router-link v-if="user.role === 'admin'" class="link d-inline-flex items-center text-white text-decoration-none me-3" :to="{ name: 'roles' }">
                    ROLES
                </router-link>

                <div class="link d-inline-flex items-center" ref="dropMenu">
                    <div @click="drop=!drop" role="button">
                        {{user.name}}
                    </div>

                    <div v-if="drop" @click="drop=!drop" class="position-absolute text-black bg-white border z-10 shadow-md flex top-100">
                        <router-link class="link dropdown-item" :to="{ name: 'home' }">
                            Home
                        </router-link>

                        <a @click="logout" class="link dropdown-item">
                            Logout
                        </a>
                    </div>
                </div>
            </div>

            <div v-else class="flex">
                <div class="text-end">
                    <router-link class="btn btn-outline-light me-2" :to="{ name: 'login' }">
                        Login
                    </router-link>
                    <router-link class="btn btn-warning" :to="{ name: 'registration' }">
                        Sign-up
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>
<script>

export default {
    created: function() {
        if(this.$store.getters.user) {
            let self = this ;
            window.addEventListener('click', function(e){
                if ( self.$refs.dropMenu && !self.$refs.dropMenu.contains(e.target) ){
                    self.drop = false;
                }
            })
        }
    },
    data() {
        return {
            drop : false ,
        }
    },
    computed : {
        user() {
            return this.$store.getters.user;
        }
    },
    methods : {
        async logout() {
            await this.$store.dispatch('logout');
            await this.$router.push({name : 'login'});
        }
    }
}
</script>
