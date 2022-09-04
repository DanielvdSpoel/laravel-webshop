<template>
    <div class="lg:relative">
        <div class="mx-auto w-full max-w-7xl pt-16 pb-20 text-center lg:py-48 lg:text-left">
            <div class="px-4 sm:px-8 lg:w-1/2 xl:pr-16">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                    <span class="block xl:inline">
                        {{ content.section_title }}
                    </span>
                </h1>
                <p class="mx-auto mt-3 max-w-md text-lg text-gray-500 sm:text-xl md:mt-5 md:max-w-3xl">
                    {{ content.section_description }}
                </p>
                <div class="mt-10 sm:flex sm:justify-center lg:justify-start gap-4">
                    <div class="rounded-md shadow" v-for="button in content.buttons" :key="button.button_text">
                        <a :href="button.button_url" class="flex w-full items-center justify-center rounded-md border border-transparent bg-primary-600 px-8 py-3 text-base font-medium text-white hover:bg-primary-700 md:py-4 md:px-10 md:text-lg">
                            {{ button.button_text }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative h-64 w-full sm:h-72 md:h-96 lg:absolute lg:inset-y-0 lg:right-0 lg:h-full lg:w-1/2">
            <img class="absolute inset-0 h-full w-full object-cover" :src="route('media', content.background)" alt="" />
        </div>
    </div>
</template>

<script>
import LoadTranslationFromObjectMixin from "../../mixins/LoadTranslationFromObjectMixin";

export default {
    name: "SplitHero",
    props: {
        content: Object
    },
    mixins: [LoadTranslationFromObjectMixin]
}
</script>

<style scoped>

</style>
