<template>
    <button @click="open = true"
        class="bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        {{ $t('profile.security.two_factor.show_recovery_keys') }}
    </button>
    <BaseModal :open="open" @close="open = false">
        <template v-slot:content>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">{{ $t('profile.security.two_factor.recovery_keys_modal.title')}}</DialogTitle>
                <ul class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <li v-for="code in recoveryCodes" class="bg-gray-100 px-3 py-2 text-red-400 rounded-md text-sm">{{ code }}</li>
                </ul>
            </div>

        </template>
        <template v-slot:buttons>
            <button @click="regenerateRecoveryKeys"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                {{ $t('profile.security.two_factor.regenerate_recovery_keys') }}
            </button>
        </template>
    </BaseModal>
</template>

<script>
import BaseModal from "../BaseModal";
import {DialogTitle} from "@headlessui/vue";
export default {
    name: "TwoFactorRecoveryKeysModal",
    components: {BaseModal, DialogTitle},
    data() {
        return {
            open: false,
            recoveryCodes: [],
        }
    },
    mounted() {
        this.collectRecoveryKeys()
    },
    watch: {
        open: function() {
            if (this.recoveryCodes.length === 0) {
                this.$inertia.post(route('two-factor.recovery-codes'));
            }
        }
    },
    methods: {
        regenerateRecoveryKeys() {
            window.axios.post(route('two-factor.recovery-codes')).then(response => {
                this.collectRecoveryKeys()
            }).catch(error => {
                console.log(error)
            })
        },
        collectRecoveryKeys() {
            window.axios.get(route('two-factor.recovery-codes')).then(response => {
                this.recoveryCodes = response.data
            }).catch(error => {
                console.log(error)
            })
        },
    }
}
</script>

<style scoped>

</style>
