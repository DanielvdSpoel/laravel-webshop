export default {
    methods: {
        loadTranslationFromObject(object) {
            return object[this.$page.props.current_language];
        },
    },
};
