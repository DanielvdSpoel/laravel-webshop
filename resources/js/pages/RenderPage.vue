<template>
    <StoreLayout :addMargin="false">
        <component v-for="content in page.content" :key="randomKey(content.type)"
                   :is="formatContentType(content.type)" :content="content.data"/>
    </StoreLayout>
</template>

<script>
import StoreLayout from "../layouts/StoreLayout";
import { v4 as uuidv4 } from 'uuid';
import HeadingWithBackground from "../components/PageBlocks/HeadingWithBackground";
import SplitHero from "../components/PageBlocks/SplitHero";
import CategoryProductsList from "../components/PageBlocks/CategoryProductsList";
export default {
    name: "RenderPage",
    components: {StoreLayout, HeadingWithBackground, SplitHero, CategoryProductsList},
    props: {
        page: Object
    },
    methods: {
        randomKey(key) {
            return key + "-" + uuidv4()
        },
        formatContentType(type) {
            return type.split('_').map(_.upperFirst).join('')

        }
    }
}
</script>

<style scoped>

</style>
