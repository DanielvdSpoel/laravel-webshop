<template>
    <div class="bg-gray-900">
        <div class="max-w-7xl mx-auto h-10 px-4 flex items-center justify-end lg:justify-between sm:px-6 lg:px-8">
            <CurrencySelector/>

            <!-- todo implement announcement system -->
            <!--<p class="flex-1 text-center text-sm font-medium text-white lg:flex-none">Get free delivery on orders over $100</p>-->

            <div v-if="user">
                <ProfileButton>
                    <MenuButton class="flex flex-1 items-center justify-end space-x-2">
                        <UserIcon class="w-6 h-6 text-white" aria-hidden="true" />
                        <p class="text-sm font-medium text-white">{{ user.full_name }}</p>
                    </MenuButton>
                </ProfileButton>
            </div>
            <div v-else class="flex flex-1 items-center justify-end space-x-6">
                <Link :href="route('register')" class="text-sm font-medium text-white hover:text-gray-100">
                    {{ $t('store.navigation.auth.register') }}
                </Link>
                <span class="h-6 w-px bg-gray-600" aria-hidden="true" />

                <Link :href="route('login')" class="text-sm font-medium text-white hover:text-gray-100">
                    {{ $t('store.navigation.auth.login') }}
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import { MenuButton } from '@headlessui/vue'

import CurrencySelector from "./CurrencySelector";
import {Link} from '@inertiajs/inertia-vue3'
import { UserIcon } from '@heroicons/vue/outline'
import ProfileButton from "./ProfileButton";

export default {
    name: "TopNavigation",
    components: {ProfileButton, CurrencySelector, Link, UserIcon, MenuButton},
    computed: {
        user() {
            return this.$page.props.auth.user
        }
    }
}
</script>

<style scoped>

</style>
