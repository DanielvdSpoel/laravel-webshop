<template>
    <div class="ml-6 border-l border-gray-200 pl-6">
        <Popover class="relative">
            <PopoverButton class="flex items-center text-gray-500 hover:text-gray-600">
                <img  :src="'/images/flags/' + currentLanguage + '.svg'" alt="" class="w-5 h-auto flex-shrink-0" />
                <span class="ml-3 text-sm">{{ $t('store.footer.update-language')}}</span>
                <span class="sr-only">{{ $t('accessibility.footer.update-language')}}</span>
            </PopoverButton>

            <PopoverPanel class="absolute z-10 text-gray-500 rounded-lg bg-gray-50 shadow py-2 bottom-[25px] left-[-55px] right-[-20px]">
                <ul>
                    <li v-for="(language, abbreviation) in availableLanguages" @click="selectLanguage(abbreviation)"
                        class="flex gap-2 py-1 px-5 hover:bg-gray-100 rounded-lg m-2 cursor-pointer">
                        <img :src="'/images/flags/' + abbreviation + '.svg'" alt="" class="w-5 h-auto flex-shrink-0" />
                        <p>{{ language }}</p>
                    </li>
                </ul>
            </PopoverPanel>
        </Popover>
    </div>
</template>

<script>
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";

export default {
    name: "LanguageSelector",
    components: {
        Popover,
        PopoverButton,
        PopoverPanel,
    },
    computed: {
        currentLanguage() {
            return this.$page.props.current_language
        },
        availableLanguages() {
            return this.$page.props.available_languages
        }
    },
    methods: {
        selectLanguage(abbreviation) {
            this.$i18n.locale = abbreviation
            this.$inertia.patch(route('update-language', {
                language: abbreviation
            }));
        }
    }
}
</script>

<style scoped>

</style>
