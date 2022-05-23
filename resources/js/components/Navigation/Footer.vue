<template>
    <footer aria-labelledby="footer-heading" class="bg-white">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- News letter / offer -->
            <!--<div class="border-t border-gray-200">
                <div class="lg:grid lg:grid-cols-2 lg:gap-x-6 xl:gap-x-8">
                    <div class="bg-gray-100 rounded-lg p-6 flex items-center sm:p-10">
                        <div class="max-w-sm mx-auto">
                            <h3 class="font-semibold text-gray-900">Sign up for our newsletter</h3>
                            <p class="mt-2 text-sm text-gray-500">The latest news, articles, and resources, sent to your inbox weekly.</p>
                            <form class="mt-4 sm:mt-6 sm:flex">
                                <label for="email-address" class="sr-only">Email address</label>
                                <input id="email-address" type="text" autocomplete="email" required="" class="appearance-none min-w-0 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500" />
                                <div class="mt-3 sm:flex-shrink-0 sm:mt-0 sm:ml-4">
                                    <button type="submit" class="w-full bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-500">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6 relative py-12 px-6 flex items-center sm:py-16 sm:px-10 lg:mt-0">
                        <div class="absolute inset-0 rounded-lg overflow-hidden">
                            <img src="https://tailwindui.com/img/ecommerce-images/footer-02-exclusive-sale.jpg" alt="" class="w-full h-full filter saturate-0 object-center object-cover" />
                            <div class="absolute inset-0 bg-primary-600 bg-opacity-90" />
                        </div>
                        <div class="relative max-w-sm mx-auto text-center">
                            <h3 class="text-2xl font-extrabold tracking-tight text-white">Get early access</h3>
                            <p class="mt-2 text-gray-200">
                                Did you sign up to the newsletter? If so, use the keyword we sent you to get access. <a href="#" class="font-bold text-white whitespace-nowrap hover:text-gray-200">Go now<span aria-hidden="true"> &rarr;</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>-->

            <div class="py-5 md:flex md:items-center md:justify-between">
                <div class="text-center md:text-left">
                    <p class="text-sm text-gray-500">{{ $t('store.footer.copyright', {year: currentYear, name: brandName}) }}</p>
                </div>

                <div class="mt-4 flex items-center justify-center md:mt-0">
                    <div class="flex space-x-8">
                        <!--<a v-for="item in footerNavigation.bottomLinks" :key="item.name" :href="item.href"
                           class="text-sm text-gray-500 hover:text-gray-600">
                            {{ item.name }}
                        </a>-->
                    </div>
                    <LanguageSelector/>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import LanguageSelector from "../LanguageSelector";
export default {
    name: "Footer",
    components: {LanguageSelector},
    computed: {
        brandName() {
            return this.$page.props.brand_name
        },
        currentYear() {
            return new Date().getFullYear()
        },
    }
}
</script>

<style scoped>

</style>
