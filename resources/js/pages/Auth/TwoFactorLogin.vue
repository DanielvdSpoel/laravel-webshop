<template>
    <AuthLayout>
        <template v-slot:title>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $t('auth.two_factor_login.title') }}
            </h2>
        </template>
        <template v-slot:form>
            <form class="space-y-6" @submit.prevent="form.post('/two-factor-challenge')">
                <CodeField
                    name="code"
                    :label="$t('forms.labels.2fa_code')"
                    :required="true"
                    :fields="6"
                    v-model="form.code"
                />
                <div>
                    <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ $t('auth.login.submit') }}
                    </button>
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
import CodeField from "../../components/Fields/CodeField";

export default {
    name: "Login",
    components: { CodeField, CheckBoxField, InputField, AuthLayout, Link},
    data() {
        return {
            form: this.$inertia.form({
                code: null,
            })
        }
    },
}
</script>

<style scoped>

</style>
