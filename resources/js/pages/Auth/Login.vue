<template>
    <AuthLayout>
        <template v-slot:title>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $t('auth.login.title') }}
            </h2>
        </template>
        <template v-slot:form>
            <form class="space-y-6" @submit.prevent="form.post(route('login'))">
                <InputField
                    name="email"
                    type="email"
                    autocomplete="email"
                    :label="$t('forms.labels.email')"
                    :required="true"
                    v-model="form.email"
                />
                <InputField
                    name="password"
                    type="password"
                    autocomplete="password"
                    :label="$t('forms.labels.password')"
                    :required="true"
                    v-model="form.password"
                />
                <div class="flex items-center justify-between">
                    <CheckBoxField
                        name="remember-me"
                        :label="$t('forms.labels.remember_me')"
                        v-model="form.remember_me"
                    />
                    <div class="text-sm">
                        <Link :href="route('password.forgot')"
                              class="font-medium text-primary-600 hover:text-primary-500">
                            {{ $t('auth.login.forgot_password') }}
                        </Link>
                    </div>
                </div>

                <div>
                    <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ $t('auth.login.submit') }}
                    </button>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"/>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">{{ $t('auth.login.or_continue_with.title') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div>
                            <a href="#"
                               class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">{{ $t('auth.login.or_continue_with.facebook') }}</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>

                        <div>
                            <a href="#"
                               class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">{{ $t('auth.login.or_continue_with.google') }}</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </AuthLayout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout";
import {Link} from '@inertiajs/inertia-vue3'
import InputField from "../../components/Fields/InputField";
import CheckBoxField from "../../components/Fields/CheckBoxField";

export default {
    name: "Login",
    components: {CheckBoxField, InputField, AuthLayout, Link},
    data() {
        return {
            form: this.$inertia.form({
                email: null,
                password: null,
            })
        }
    },
}
</script>

<style scoped>

</style>
