<template>
    <button @click="open = true"
        class="bg-danger-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger-500">
        {{ openButtonText }}
    </button>
    <BaseModal
        :open="open"
        :showCancel="true"
        @close="open = false">

        <template v-slot:buttons>
            <button @click="$emit('confirmed'); open = false"
                type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-danger-600 text-base font-medium text-white hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger-500 sm:ml-3 sm:w-auto sm:text-sm">
                {{ confirmButtonText }}
            </button>
        </template>

        <template v-slot:content>
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-danger-100 sm:mx-0 sm:h-10 sm:w-10">
                <ExclamationIcon class="h-6 w-6 text-danger-600" aria-hidden="true" />
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">{{ title }}</DialogTitle>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">{{ description }}</p>
                </div>
                <slot/>
            </div>
        </template>
    </BaseModal>
</template>

<script>
import BaseModal from "../BaseModal";
import {DialogTitle} from "@headlessui/vue";
import { ExclamationIcon } from '@heroicons/vue/outline'
export default {
    name: "ConfirmModal",
    components: {BaseModal, DialogTitle, ExclamationIcon},
    emits: ["confirmed"],
    props: {
        openButtonText: String,
        title: String,
        description: String,
        confirmButtonText: String,
    },
    data() {
        return {
            open: false,
        };
    },
}
</script>

<style scoped>

</style>
