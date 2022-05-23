<template>
    <TransitionRoot as="template" :show="isMenuOpen">
        <Dialog as="div" class="relative z-40 lg:hidden" @close="$emit('close')">
            <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                             enter-from="opacity-0" enter-to="opacity-100"
                             leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                             leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25"/>
            </TransitionChild>

            <div class="fixed inset-0 flex z-40">
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                 enter-from="-translate-x-full" enter-to="translate-x-0"
                                 leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                 leave-to="-translate-x-full">
                    <DialogPanel
                        class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto">
                        <div class="px-4 pt-5 pb-2 flex">
                            <button type="button"
                                    class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-gray-400"
                                    @click="$emit('close')">
                                <span class="sr-only">Close menu</span>
                                <XIcon class="h-6 w-6" aria-hidden="true"/>
                            </button>
                        </div>

                        <!-- Links -->
                        <TabGroup as="div" class="mt-2">
                            <div class="border-b border-gray-200">
                                <TabList class="-mb-px flex px-4 space-x-8">
                                    <Tab as="template" v-for="category in categories"
                                         :key="category.name" v-slot="{ selected }">
                                        <button
                                            :class="[selected ? 'text-primary-600 border-primary-600' : 'text-gray-900 border-transparent', 'flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium']">
                                            {{ category.name }}
                                        </button>
                                    </Tab>
                                </TabList>
                            </div>
                            <TabPanels as="template">
                                <TabPanel v-for="category in categories"
                                          :key="category.name" class="px-4 pt-10 pb-6 space-y-12">
                                    <div class="grid grid-cols-1 items-start gap-y-10 gap-x-6">
                                        <div class="grid grid-cols-1 gap-y-10 gap-x-6">
                                            <div v-for="childCategory in category.children">
                                                <p :id="`mobile-subcategory-heading-${childCategory.id}`"
                                                   class="font-medium text-gray-900">{{ childCategory.name }}</p>
                                                <ul role="list"
                                                    :aria-labelledby="`mobile-featured-heading-${childCategory.id}`"
                                                    class="mt-6 space-y-6">
                                                    <li v-for="subCategory in childCategory.children" :key="subCategory.name"
                                                        class="flex">
                                                        <a :href="subCategory.href" class="text-gray-500">
                                                            {{ subCategory.name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!--<div>
                                                <p id="mobile-categories-heading" class="font-medium text-gray-900">
                                                    Categories</p>
                                                <ul role="list" aria-labelledby="mobile-categories-heading"
                                                    class="mt-6 space-y-6">
                                                    <li v-for="item in category.categories" :key="item.name"
                                                        class="flex">
                                                        <a :href="item.href" class="text-gray-500">
                                                            {{ item.name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>-->
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-10 gap-x-6">
                                            <div>
                                                <p id="mobile-collection-heading" class="font-medium text-gray-900">
                                                    {{ $t('store.navigation.collections') }}}
                                                </p>
                                                <ul role="list" aria-labelledby="mobile-collection-heading"
                                                    class="mt-6 space-y-6">
                                                    <li v-for="collection in category.collections" :key="collection.name"
                                                        class="flex">
                                                        <a :href="collection.href" class="text-gray-500">
                                                            {{ collection.name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div>
                                                <p id="mobile-brand-heading" class="font-medium text-gray-900">
                                                    {{ $t('store.navigation.collections') }}}
                                                </p>
                                                <ul role="list" aria-labelledby="mobile-brand-heading"
                                                    class="mt-6 space-y-6">
                                                    <li v-for="item in category.brands" :key="item.name"
                                                        class="flex">
                                                        <a :href="item.href" class="text-gray-500">
                                                            {{ item.name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </TabPanel>
                            </TabPanels>
                        </TabGroup>

                        <div class="border-t border-gray-200 py-6 px-4 space-y-6">
                            <!-- todo implement pages -->
                           <!-- <div v-for="page in navigation.pages" :key="page.name" class="flow-root">
                                <a :href="page.href" class="-m-2 p-2 block font-medium text-gray-900">{{
                                        page.name
                                    }}</a>
                            </div>-->
                        </div>

                        <div class="border-t border-gray-200 py-6 px-4 space-y-6">
                            <div class="flow-root">
                                <Link :href="route('register')" class="-m-2 p-2 block font-medium text-gray-900">
                                    {{ $t('store.navigation.auth.register') }}
                                </Link>
                            </div>
                            <div class="flow-root">
                                <Link :href="route('register')" class="-m-2 p-2 block font-medium text-gray-900">
                                    {{ $t('store.navigation.auth.register') }}
                                </Link>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-6 px-4 space-y-6">
                            <CurrencySelector :mobile="true"/>
                            <!-- Currency selector -->

                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>

</template>

<script setup>
import {
    Dialog,
    DialogPanel,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {XIcon} from '@heroicons/vue/outline'
import CurrencySelector from "./CurrencySelector";
import {Link} from '@inertiajs/inertia-vue3'

</script>

<script>
export default {
    name: "MobileMenu",
    props: {
        isMenuOpen: Boolean,
        categories: Array,
    }
}
</script>

<style scoped>

</style>
