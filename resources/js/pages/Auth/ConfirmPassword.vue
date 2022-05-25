<template>
    <AuthLayout>
        <template v-slot:title>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $t('auth.confirm_password.title') }}
            </h2>
        </template>
        <template v-slot:form>
            <form class="space-y-6" @submit.prevent="form.post(route('password.confirm'))">
                <InputField
                    name="password"
                    type="password"
                    autocomplete="password"
                    :label="$t('forms.labels.password')"
                    :required="true"
                    v-model="form.password"
                />
                <div>
                    <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ $t('auth.confirm_password.submit') }}
                    </button>
                </div>
            </form>
        </template>
    </AuthLayout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout";
import InputField from "../../components/Fields/InputField";

export default {
    name: "ConfirmPassword",
    components: {InputField, AuthLayout},
    data() {
        return {
            form: this.$inertia.form({
                password: null,
            })
        }
    },}
</script>

<style scoped>

</style>
