<template>
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <ExclamationIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    {{ $t('notifications.email_not_verified.title')}}
                    {{ ' ' }}
                    <Link as="button" method="post" :href="route('verification.send')" class="font-medium underline text-yellow-700 hover:text-yellow-600">
                        {{ $t('notifications.email_not_verified.message')}}
                    </link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ExclamationIcon } from '@heroicons/vue/solid'
import {Link} from '@inertiajs/inertia-vue3'

</script>

<script>
export default {
    name: "EmailVerificationNotification"
}
</script>

<style scoped>

</style>
