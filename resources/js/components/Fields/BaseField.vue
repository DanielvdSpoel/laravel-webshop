<template>
    <div>
        <div class="flex mt-1">
            <label :for="name" class="block text-sm font-medium text-gray-700 mt-1">{{ label }}</label>
            <span class="text-red-600 ml-0.5" v-if="required">*</span>
        </div>
        <slot/>
        <p v-if="description" class="mt-2 text-sm text-gray-500" id="email-description">{{ description }}</p>
        <p v-if="error" class="mt-2 text-sm text-red-600" id="email-error">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: "BaseField",
    props: {
        form: Object,
        name: String,
        label: String,
        description: String,
        required: Boolean,
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
