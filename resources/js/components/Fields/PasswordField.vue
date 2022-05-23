<template>
    <BaseField :name="name" :label="label" :description="description" :required="required" :form="form">
        <div class="mt-1 flex rounded-md shadow-sm">
            <div class="relative flex items-stretch flex-grow focus-within:z-10">
                <input :type="showPassword ? 'text' : 'password'" :name="name" :id="name" :autocomplete="autocomplete"
                       @input="$emit('update:modelValue', $event.target.value)" v-model="modelValue"
                       class="block w-full pr-10 border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-l-md"
                       :placeholder="placeholder"
                       v-bind:class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500': error}"
                />
                <div v-if="error" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <!-- Heroicon name: solid/exclamation-circle -->
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <button @click="showPassword = !showPassword" type="button" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <EyeOffIcon v-if="showPassword" class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                <EyeIcon v-else class="h-5 w-5 text-gray-400" aria-hidden="true"/>
            </button>
        </div>
    </BaseField>
</template>

<script>
import BaseField from "./BaseField";
import {EyeIcon, EyeOffIcon} from '@heroicons/vue/outline'

export default {
    name: "PasswordField",
    components: {BaseField, EyeIcon, EyeOffIcon},
    props: {
        modelValue: String,
        form: Object,
        name: String,
        label: String,
        placeholder: String,
        description: String,
        required: Boolean,
        disabled: Boolean,
        autocomplete: String,
    },
    data() {
        return {
            showPassword: false,
        };
    },
    computed: {
        error() {
            if (this.form) {
                if (this.form.errors[this.name]) {
                    return this.form.errors[this.name];
                }
                return null
            }
            if (this.$page.props.errors[this.name]) {
                return this.$page.props.errors[this.name]
            }
            return null
        }
    }
}
</script>
