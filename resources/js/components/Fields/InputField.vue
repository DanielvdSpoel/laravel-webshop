<template>
    <BaseField :name="name" :label="label" :description="description" :required="required" :form="form">
        <div class="mt-1 relative rounded-md shadow-sm">
            <input :type="type" :name="name" :id="name" :autocomplete="autocomplete" :min="min" :max="max"
                   @input="$emit('update:modelValue', $event.target.value)" v-model="modelValue"
                   class="block w-full pr-10 border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
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
    </BaseField>
</template>

<script>
import BaseField from "./BaseField";

export default {
    name: "InputField",
    components: {BaseField},
    props: {
        modelValue: String|Number,
        form: Object,
        name: String,
        label: String,
        placeholder: String,
        description: String,
        required: Boolean,
        type: String,
        disabled: Boolean,
        autocomplete: String,
        min: Number,
        max: Number,
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
