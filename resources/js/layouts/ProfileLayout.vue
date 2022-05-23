<template>
    <StoreLayout>
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                <nav class="space-y-1">
                    <a :href="route('profile.account')" :class="[route().current('profile.account') ? 'bg-gray-50 text-primary-700 hover:text-primary-700 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50', 'group rounded-md px-3 py-2 flex items-center text-sm font-medium']" :aria-current="route().current('profile.account') ? 'page' : undefined">
                        <UserCircleIcon :class="[route().current('profile.account') ? 'text-primary-500 group-hover:text-primary-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                        <span class="truncate">
                            {{ $t('profile.nav.account')}}
                        </span>
                    </a>
                    <a :href="route('profile.security')" :class="[route().current('profile.security') ? 'bg-gray-50 text-primary-700 hover:text-primary-700 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50', 'group rounded-md px-3 py-2 flex items-center text-sm font-medium']" :aria-current="route().current('profile.security') ? 'page' : undefined">
                        <KeyIcon :class="[route().current('profile.security') ? 'text-primary-500 group-hover:text-primary-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                        <span class="truncate">
                            {{ $t('profile.nav.security')}}
                        </span>
                    </a>
                </nav>
            </aside>
            <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                <slot/>
            </div>
        </div>
    </StoreLayout>
</template>

<script>
import StoreLayout from "./StoreLayout";
import {KeyIcon, UserCircleIcon} from '@heroicons/vue/outline'
export default {
    name: "ProfileLayout",
    components: {StoreLayout, UserCircleIcon, KeyIcon}

}
</script>

<style scoped>

</style>
