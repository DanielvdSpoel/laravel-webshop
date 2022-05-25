<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $t('profile.security.two_factor.title') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500" v-if="confirming === false">
                    {{ $t('profile.security.two_factor.description') }}</p>
                <p class="mt-1 max-w-2xl text-sm text-gray-500" v-else-if="confirming">
                    {{ $t('profile.security.two_factor.confirming_description') }}</p>
                <div class="mt-2" v-if="qr" v-html="qr">
                </div>
                <div class="mt-2" v-if="setupKey">
                    <p class="font-semibold">
                        {{ $t('profile.security.two_factor.setup_key') }} <span v-html="setupKey"></span>
                    </p>
                </div>
                <div v-if="confirming">
                    <InputField
                        name="code"
                        type="text"
                        :required="true"
                        :form="form"
                        v-model="form.code"
                        :label="$t('forms.labels.two_factor_confirm_code')"
                    />
                </div>

            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button v-if="!isMFAEnabled && !confirming" :disabled="loading" @click="setupMFA"
                    class="bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ $t('profile.security.two_factor.setup') }}
            </button>
            <button v-if="confirming" :disabled="loading" @click="confirmMFA"
                    class="bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ $t('profile.security.two_factor.confirm') }}
            </button>
            <div v-if="isMFAEnabled" class="flex flex-wrap gap-3 justify-end">
                <TwoFactorRecoveryKeysModal/>
                <ConfirmModal
                    :title="$t('profile.security.two_factor.remove_confirm.title')"
                    :description="$t('profile.security.two_factor.remove_confirm.description')"
                    :open-button-text="$t('profile.security.two_factor.remove')"
                    :confirm-button-text="$t('profile.security.two_factor.remove')"
                    @confirmed="disableMFA"
                />

            </div>
        </div>

    </div>

</template>

<script>
import InputField from "../Fields/InputField";
import ConfirmModal from "./ConfirmModal";
import TwoFactorRecoveryKeysModal from "./TwoFactorRecoveryKeysModal";

export default {
    name: "TwoFactorAuthenticationCard",
    components: {TwoFactorRecoveryKeysModal, ConfirmModal, InputField},
    props: {
        user: Object,
    },
    data() {
        return {
            loading: false,
            confirming: false,
            qr: null,
            setupKey: null,
            form: this.$inertia.form({
                code: null,
            }),
        }
    },
    computed: {
        isMFAEnabled() {
            return this.user.two_factor_confirmed_at;
        },
    },
    methods: {
        disableMFA() {
            this.$inertia.delete(route('two-factor.disable'), {
                preserveScroll: true,
            })
        },
        setupMFA() {
            this.loading = true
            this.$inertia.post(route('two-factor.enable'), {}, {
                preserveScroll: true,
                onSuccess: page => {
                    this.loadQRCode()
                    this.loadSetupKey()
                },
                onFinish: () => {
                    this.loading = false;
                    this.confirming = true;
                },
            })
        },
        confirmMFA() {
            this.loading = true
            this.form.post(route('two-factor.confirm'), {
                errorBag: "confirmTwoFactorAuthentication",
                preserveScroll: true,
                onSuccess: () => {
                    this.confirming = false;
                    this.loading = false;
                    this.qr = null;
                    this.setupKey = null;
                },
                onFinish: () => {
                    this.loading = false;
                },
            })
        },
        loadQRCode() {
            window.axios.get(route('two-factor.qr-code')).then(result => {
                this.qr = result.data.svg
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        loadSetupKey() {
            window.axios.get(route('two-factor.secret-key')).then(result => {
                this.setupKey = result.data.secretKey
            }).catch(error => {
                console.log(error.response.data)
            })
        },
    }
}
</script>

<style scoped>

</style>
