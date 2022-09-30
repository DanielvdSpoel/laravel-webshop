<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ content.header_text }}</h2>
                <a href="#" class="hidden text-sm font-medium text-primary-600 hover:text-primary-500 md:block">
                    Shop the collection
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                <div v-for="product in products" :key="product.id" class="group relative">
                    <div class="h-56 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:h-72 xl:h-80">
                        <img :src="product.imageSrc" :alt="product.imageAlt" class="h-full w-full object-cover object-center" />
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">
                        <a :href="product.href">
                            <span class="absolute inset-0" />
                            {{ product.name }}
                        </a>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}</p>
                </div>
            </div>

            <div class="mt-8 text-sm md:hidden">
                <a href="#" class="font-medium text-primary-600 hover:text-primary-500">
                    Shop the collection
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CategoryProductsList",
    props: {
        content: Object
    },
    mounted() {
        this.loadProducts();
        this.loadCategory();
    },
    methods: {
        loadProducts() {
            axios.get(route('api.products.index'))
                .then(response => {
                    this.products = response.data.data
                });
        },
        loadCategory() {
            axios.get(route('api.categories.show', {category: this.content.category}))
                .then(response => {
                    this.category = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    data() {
        return {
            category: null,
            products: null
        }
    }
}
</script>

<style scoped>

</style>
