<template>
    <BaseField :name="name" :label="label" :description="description" :required="required" :form="form">
        <textarea :id="name" :name="name" :rows="rows"
                  @input="$emit('update:modelValue', $event.target.value)" type= "text" v-model="modelValue"
                  class="block w-full pr-10 border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                  :placeholder="placeholder"
                  v-bind:class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500': error}"
        >{{ modelValue }}
        </textarea>
    </BaseField>
</template>

<script>
import BaseField from "./BaseField";
export default {
    name: "TextareaField",
    components: {BaseField},
    props: {
        modelValue: Number,
        form: Object,
        name: String,
        label: String,
        placeholder: String,
        description: String,
        required: Boolean,
        type: String,
        disabled: Boolean,
        autocomplete: String,
        rows: {
            type: Number,
            default: 5
        }
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

<style scoped>

</style>
