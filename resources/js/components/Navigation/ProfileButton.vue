<template>
    <div class="flex flex-wrap gap-2 justify-end">
        <div class="">
            <Menu as="div" class="relative inline-block text-left">
                <div class="">
                    <slot></slot>
                </div>

                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems class="z-50 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                        <div class="px-4 py-3">
                            <p class="text-sm">{{ $t('profile.menu.logged_in_as')}}</p>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ user.email }}</p>
                        </div>
                        <div class="py-1">
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('profile.account')" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                    {{ $t('profile.menu.profile') }}
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <Link href="" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                    {{ $t('profile.menu.previous_orders') }}
                                </Link>
                            </MenuItem>
                        </div>
                        <div class="py-1">
                            <MenuItem v-slot="{ active }">
                                <Link as="button" method="post" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block w-full text-left px-4 py-2 text-sm']" :href="route('logout')">
                                    {{ $t('profile.menu.logout') }}

                                </Link>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
    </div>
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/solid'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    name: "ProfileButton",
    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        ChevronDownIcon,
        Link,
    },
    computed: {
        user() {
            return this.$page.props.auth.user
        },
    }
}
</script>

<style scoped>

</style>
