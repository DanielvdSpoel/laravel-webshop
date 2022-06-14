<template>
    <div class="bg-white">
        <div class="border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-16 flex items-center justify-between">
                    <!-- Logo (lg+) -->
                    <div class="hidden lg:flex lg:items-center">
                        <a href="#">
                            <span class="sr-only">Workflow</span>
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=primary&shade=600" alt="" />
                        </a>
                    </div>

                    <div class="hidden h-full lg:flex">
                        <!-- Mega menus -->
                        <PopoverGroup class="ml-8">
                            <div class="h-full flex justify-center space-x-8">
                                <Popover v-for="category in categories" :key="category.name" class="flex" v-slot="{ open }">
                                    <div class="relative flex">
                                        <PopoverButton :class="[open ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-700 hover:text-gray-800', 'relative z-10 flex items-center transition-colors ease-out duration-200 text-sm font-medium border-b-2 -mb-px pt-px']">
                                            {{ loadTranslationFromObject(category.name) }}
                                        </PopoverButton>
                                    </div>

                                    <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <PopoverPanel class="absolute top-full inset-x-0 text-gray-500 sm:text-sm">
                                            <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                                            <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true" />

                                            <div class="relative bg-white">
                                                <div class="max-w-7xl mx-auto px-8">
                                                    <ul class="grid grid-cols-4 items-start gap-y-10 gap-x-8 pt-10 pb-12">
                                                        <li v-for="childCategory in category.children">
                                                            <p :id="`desktop-child-category-heading-${childCategory.id}`" class="font-medium text-gray-900">
                                                                {{ loadTranslationFromObject(childCategory.name) }}
                                                            </p>
                                                            <ul role="list" :aria-labelledby="`desktop-child-category-heading-${childCategory.id}`" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                                                <li v-for="item in childCategory.children" :key="item.name" class="flex">
                                                                    <a :href="item.href" class="hover:text-gray-800">
                                                                        {{ loadTranslationFromObject(item.name) }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <p id="desktop-collection-heading" class="font-medium text-gray-900">
                                                                {{ $t('store.navigation.collections') }}

                                                            </p>
                                                            <ul role="list" aria-labelledby="desktop-collection-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                                                <li v-for="collection in category.collections" :key="collection.name" class="flex">
                                                                    <a :href="collection.href" class="hover:text-gray-800">
                                                                        {{ collection.name }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>

                                                        <li>
                                                            <p id="desktop-brand-heading" class="font-medium text-gray-900">
                                                                {{ $t('store.navigation.brands') }}
                                                            </p>
                                                            <ul role="list" aria-labelledby="desktop-brand-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                                                <li v-for="item in category.brands" :key="item.name" class="flex">
                                                                    <a :href="item.href" class="hover:text-gray-800">
                                                                        {{ item.name }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <!--<a v-for="page in navigation.pages" :key="page.name" :href="page.href" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">{{ page.name }}</a> -->
                            </div>
                        </PopoverGroup>
                    </div>

                    <!-- Mobile menu and search (lg-) -->
                    <div class="flex-1 flex items-center lg:hidden">
                        <button type="button" class="-ml-2 bg-white p-2 rounded-md text-gray-400" @click="$emit('openMobileMenu')">
                            <span class="sr-only">Open menu</span>
                            <MenuIcon class="h-6 w-6" aria-hidden="true" />
                        </button>

                        <!-- Search -->
                        <a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Search</span>
                            <SearchIcon class="w-6 h-6" aria-hidden="true" />
                        </a>
                    </div>

                    <!-- Logo (lg-) -->
                    <a href="#" class="lg:hidden">
                        <span class="sr-only">Workflow</span>
                        <img src="https://tailwindui.com/img/logos/workflow-mark.svg?color=primary&shade=600" alt="" class="h-8 w-auto" />
                    </a>

                    <div class="flex-1 flex items-center justify-end">
                        <div class="flex items-center lg:ml-8">
                            <div class="flex space-x-8" :class="user ? 'mt-4' : ''">
                                <div class="hidden lg:flex">
                                    <a href="#" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Search</span>
                                        <SearchIcon class="w-6 h-6" aria-hidden="true" />
                                    </a>
                                </div>

                                <div v-if="user">
                                    <ProfileButton>
                                        <MenuButton class="flex flex-1 items-center justify-end space-x-2">
                                            <div class="flex">
                                                <a href="#" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Account</span>
                                                    <UserIcon class="w-6 h-6" aria-hidden="true" />
                                                </a>
                                            </div>
                                        </MenuButton>
                                    </ProfileButton>
                                </div>

                            </div>

                            <span class="mx-4 h-6 w-px bg-gray-200 lg:mx-6" aria-hidden="true" />

                            <div class="flow-root">
                                <a href="#" class="group -m-2 p-2 flex items-center">
                                    <ShoppingCartIcon class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                                    <span class="sr-only">items in cart, view bag</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { MenuIcon, SearchIcon, ShoppingCartIcon, UserIcon, XIcon } from '@heroicons/vue/outline'
import {Popover, PopoverButton, PopoverGroup, PopoverPanel, MenuButton} from "@headlessui/vue";
import ProfileButton from "./ProfileButton";
import LoadTranslationFromObjectMixin from "../../mixins/LoadTranslationFromObjectMixin";
export default {
    name: "Navbar",
    components: {
        MenuIcon,
        SearchIcon,
        ShoppingCartIcon,
        UserIcon,
        XIcon,
        Popover,
        PopoverButton,
        PopoverGroup,
        PopoverPanel,
        MenuButton,
        ProfileButton
    },
    mixins: [LoadTranslationFromObjectMixin],
    computed: {
        categories() {
            return this.$page.props.categories ?? []
        },
        user() {
            return this.$page.props.auth.user
        },
    }
}
</script>

<style scoped>

</style>
