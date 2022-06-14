<template>
    <div class="bg-gray-100 flex flex-col h-screen">
        <!-- Mobile menu -->
        <MobileMenu :is-menu-open="mobileMenuOpen" :categories="categories" @close="mobileMenuOpen = false"
        />

        <header class="relative z-10">
            <nav aria-label="Top">

                <EmailVerificationNotification v-if="hasVerifiedEmail !== null && !hasVerifiedEmail"/>

                <!-- Top navigation -->
                <TopNavigation/>

                <!-- Secondary navigation -->
                <Navbar @openMobileMenu="mobileMenuOpen = true"/>
            </nav>
        </header>

        <main class="mb-auto bg-gray-100">
            <div :class="{'m-5': addMargin}">
                <slot/>
            </div>
        </main>

        <Footer/>

        <Notifications/>
    </div>
</template>

<script setup>
import TopNavigation from "../components/Navigation/TopNavigation";
import Navbar from "../components/Navigation/Navbar";
import LanguageSelector from "../components/LanguageSelector";
import Notifications from "../components/Notifications";
import MobileMenu from "../components/Navigation/MobileMenu";
import EmailVerificationNotification from "../components/Navigation/EmailVerificationNotification";
import Footer from "../components/Navigation/Footer";
</script>

<script>
export default {
    name: "StoreLayout",
    props: {
        addMargin: {
            type: Boolean,
            default: true,
        }
    },
    data() {
        return {
            mobileMenuOpen: false,
        }
    },
    computed: {
        hasVerifiedEmail() {
            return this.$page.props.auth.has_verified_email
        },
        categories() {
            return this.$page.props.categories ?? []
        },
    }
}
</script>
