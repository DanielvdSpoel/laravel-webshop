<template>
    <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="show" class="z-[1005] max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <CheckCircleIcon v-if="notification.type === 'success'" class="h-6 w-6 text-green-400" aria-hidden="true" />
                        <XCircleIcon v-else class="h-6 w-6 text-red-400" aria-hidden="true" />
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900">
                            {{ notification.title }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ notification.message }}
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="sr-only">Close</span>
                            <XIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>

</template>

<script>
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/outline'
import { XIcon } from '@heroicons/vue/solid'

export default {
    name: "NotificationCard",
    props: {
        notification: String,
    },
    components: {
        CheckCircleIcon,
        XCircleIcon,
        XIcon,
    },
    data() {
        return {
            show: true,
        }
    },
    watch: {
        message() {
            this.show = true
            const that = this
            setTimeout(function(){
                that.show = false
            }, 4000);
        }
    },
    computed: {
        message() {
            return this.notification.message
        },
    },
    mounted() {
        const that = this
        setTimeout(function(){
            that.show = false
        }, 4000);
    }
}
</script>

<style scoped>

</style>
