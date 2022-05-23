<template>
    <ProfileLayout>
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <form @submit.prevent="update(['first_name', 'last_name'])">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $t('profile.account.user_details.title')}}</h3>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <InputField
                            type="text"
                            name="first_name"
                            :required="true"
                            v-model="form.first_name"
                            :label="$t('forms.labels.first_name')"
                        />
                        <InputField
                            type="text"
                            name="last_name"
                            :required="true"
                            v-model="form.last_name"
                            :label="$t('forms.labels.last_name')"
                        />

                    </div>

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ $t('forms.labels.save')}}
                    </button>
                </div>
            </form>

        </div>
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <form @submit.prevent="update(['email', 'current_password'])">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $t('profile.account.email.title')}}</h3>
                    </div>
                    <InputField
                        type="email"
                        name="email"
                        :required="true"
                        v-model="form.email"
                        :label="$t('forms.labels.email')"
                    />
                    <PasswordField
                        name="current_password"
                        :required="true"
                        v-model="form.current_password"
                        :label="$t('forms.labels.current_password')"
                    />

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ $t('forms.labels.save')}}
                    </button>
                </div>
            </form>

        </div>

    </ProfileLayout>
</template>

<script>
import ProfileLayout from "../../layouts/ProfileLayout";
import InputField from "../../components/Fields/InputField";
import PasswordField from "../../components/Fields/PasswordField";
export default {
    name: "Account",
    components: {PasswordField, InputField, ProfileLayout},
    props: {
        user: Object,
    },
    data() {
        return {
            form: {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                email: this.user.email,
                current_password: null,
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
                preserveScroll: true,
            })
        }
    }
}
</script>

<style scoped>

</style>
