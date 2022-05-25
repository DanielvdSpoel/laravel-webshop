<template>
    <ProfileLayout>
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <form @submit.prevent="update(['new_password', 'new_password_confirmation', 'current_password'])">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $t('profile.security.password.title')}}</h3>
                    </div>
                    <PasswordField
                        name="current_password"
                        :required="true"
                        v-model="form.current_password"
                        :label="$t('forms.labels.current_password')"
                    />
                    <PasswordField
                        name="new_password"
                        :required="true"
                        v-model="form.new_password"
                        :label="$t('forms.labels.new_password')"
                    />
                    <PasswordField
                        name="new_password_confirmation"
                        :required="true"
                        v-model="form.new_password_confirmation"
                        :label="$t('forms.labels.new_password_confirmation')"
                    />

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ $t('forms.labels.save')}}
                    </button>
                </div>
            </form>

        </div>
        <TwoFactorAuthenticationCard :user="user"/>
    </ProfileLayout>
</template>

<script>
import ProfileLayout from "../../layouts/ProfileLayout";
import InputField from "../../components/Fields/InputField";
import PasswordField from "../../components/Fields/PasswordField";
import TwoFactorAuthenticationCard from "../../components/Profile/TwoFactorAuthenticationCard";
export default {
    name: "Account",
    components: {TwoFactorAuthenticationCard,  PasswordField, InputField, ProfileLayout},
    props: {
        user: Object,
    },
    data() {
        return {
            form: {
                current_password: null,
                new_password: null,
                new_password_confirmation: null,
            },
        }
    },
    methods: {
        update(fields) {
            const object = {}
            fields.forEach(field => {
                object[field] = this.form[field]
            })
            this.$inertia.patch(route('profile.update'), object, {
                onSuccess: () => {
                    this.form.current_password = null;
                    this.form.new_password = null;
                    this.form.new_password_confirmation = null;
                },
                preserveScroll: true,
            })
        }
    }
}
</script>

<style scoped>

</style>
