<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <!-- Global notification live region, render this permanently at the end of the document -->
    <div aria-live="assertive" class="z-[1005] fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div class="z-[1005] w-full flex flex-col items-center space-y-4 sm:items-end">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <NotificationCard v-for="message in messages" :title="message.title" :message="message.message" :type="message.type"/>
        </div>
    </div>
</template>

<script>
import NotificationCard from "./NotificationCard";
export default {
    name: "Notifications",
    components: {NotificationCard},
    computed: {
        messages() {
            return this.$page.props.messages
        }
    }

}
</script>
