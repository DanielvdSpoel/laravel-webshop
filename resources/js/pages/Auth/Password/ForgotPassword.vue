<template>
    <AuthLayout>
        <template v-slot:title>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $t('auth.forgot_password.title')}}
            </h2>
        </template>
        <template v-slot:form>
            <form class="space-y-6" @submit.prevent="submitForm()">
                <InputField
                    name="email"
                    type="email"
                    autocomplete="email"
                    label="E-mailadres"
                    :required="true"
                    v-model="form.email"
                />
                <p v-if="success" class="mt-2 text-sm text-green-600">
                    {{ $t('auth.forgot_password.success')}}

                </p>

                <div>
                    <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ $t('auth.forgot_password.submit')}}

                    </button>
                </div>
            </form>
        </template>
    </AuthLayout>
</template>

<script>
import AuthLayout from "../../../layouts/AuthLayout";
import InputField from "../../../components/Fields/InputField";
import {Link} from '@inertiajs/inertia-vue3'

export default {
    name: "PasswordEmail",
    components: {InputField, AuthLayout, Link},
    data() {
        return {
            form: this.$inertia.form({
                email: "",
            }),
            success: false,
        }
    },
    methods: {
        submitForm() {
            this.success = false;
            this.form.post(route('password.email'), {
                onSuccess: page => {
                    this.success = true;
                },

            });
        }
    }
}
</script>

<style scoped>
</style>
