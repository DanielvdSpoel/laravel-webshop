<template>
    <StoreLayout>
        <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <slot name="title"></slot>
                <slot name="subtitle"></slot>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-gray-50 py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <slot name="form"></slot>
                </div>
            </div>
        </div>
    </StoreLayout>
</template>
<script>
import StoreLayout from "./StoreLayout";
export default {
    name: "AuthLayout",
    components: {StoreLayout}
}
</script>

<style scoped>

</style>
