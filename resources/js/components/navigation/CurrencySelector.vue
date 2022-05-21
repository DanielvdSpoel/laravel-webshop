<template>
    <form v-if="mobile">
        <div class="inline-block">
            <label for="mobile-currency" class="sr-only">Currency</label>
            <div
                class="-ml-2 group relative border-transparent rounded-md focus-within:ring-2 focus-within:ring-white">
                <select id="mobile-currency" name="currency" v-model="selectedCurrency"
                        class="bg-none border-transparent rounded-md py-0.5 pl-2 pr-5 flex items-center text-sm font-medium text-gray-700 group-hover:text-gray-800 focus:outline-none focus:ring-0 focus:border-transparent">
                    <option v-for="currency in availableCurrencies" :key="currency">{{ currency }}</option>
                </select>
                <div
                    class="absolute right-0 inset-y-0 flex items-center pointer-events-none">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 20 20" class="w-5 h-5 text-gray-500">
                        <path stroke="currentColor" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/>
                    </svg>
                </div>
            </div>
        </div>
    </form>
    <form v-else class="hidden lg:block lg:flex-1">
        <div class="flex">
            <label for="desktop-currency" class="sr-only">Currency</label>
            <div class="-ml-2 group relative bg-gray-900 border-transparent rounded-md focus-within:ring-2 focus-within:ring-white">
                <select v-model="selectedCurrency" id="desktop-currency" name="currency" class="bg-none bg-gray-900 border-transparent rounded-md py-0.5 pl-2 pr-5 flex items-center text-sm font-medium text-white group-hover:text-gray-100 focus:outline-none focus:ring-0 focus:border-transparent">
                    <option v-for="currency in availableCurrencies" :key="currency">{{ currency }}</option>
                </select>
                <div class="absolute right-0 inset-y-0 flex items-center pointer-events-none">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" class="w-5 h-5 text-gray-300">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4" />
                    </svg>
                </div>
            </div>
        </div>
    </form>

</template>

<script>
export default {
    name: "CurrencySelector",
    props: {
        mobile: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        availableCurrencies() {
            return this.$page.props.available_currencies
        },
    },
    data() {
        return {
            selectedCurrency: this.$page.props.available_currencies[0],
        }
    },
    watch: {
        selectedCurrency(newCurrency) {
            console.log(newCurrency)
        },
    },
}
</script>

<style scoped>

</style>
