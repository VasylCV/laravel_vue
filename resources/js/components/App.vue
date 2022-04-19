<template>
    <div>
        <div>
            <nav-bar></nav-bar>
        </div>
        <div>

            <router-view class="p-6 " v-slot="{ Component }">
                <transition name="fade" mode="out-in" >
                    <component :is="Component" />
                </transition>
            </router-view>
        </div>
    </div>
</template>

<script>
import NavBar from './NavBar.vue'
export default {
    computed : {
        id () {
            return this.$store.getters.id
        },
        verified () {
            return this.$store.getters.verified
        }
    },
    components : {
        NavBar,
    },
}
</script>
