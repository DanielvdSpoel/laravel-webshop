<template>
    <div class="bg-gray-900">
        <div class="max-w-7xl mx-auto h-10 px-4 flex items-center justify-between sm:px-6 lg:px-8">
            <CurrencySelector/>

            <!-- todo implement announcement system -->
            <!--<p class="flex-1 text-center text-sm font-medium text-white lg:flex-none">Get free delivery on orders over $100</p>-->

            <div class="flex flex-1 items-center justify-end space-x-6">
                <a href="#" class="text-sm font-medium text-white hover:text-gray-100">{{ $t('store.navigation.auth.register') }}</a>
                <span class="h-6 w-px bg-gray-600" aria-hidden="true" />
                <a href="#" class="text-sm font-medium text-white hover:text-gray-100">{{ $t('store.navigation.auth.login') }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import CurrencySelector from "./CurrencySelector";
export default {
    name: "TopNavigation",
    components: {CurrencySelector}
}
</script>

<style scoped>

</style>
