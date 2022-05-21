<template>
        <Popover class="relative mt-20">
            <PopoverButton>Solutions</PopoverButton>

            <PopoverPanel class="absolute z-10 rounded-lg bg-gray-200 p-4 bottom-[20px]">
                <ul>
                    <li class="flex gap-2">
                        <img src="/images/flags/nl.svg" alt="" class="w-5 h-auto flex-shrink-0" />
                        <a>Nederlands</a>
                    </li>
                    <li class="flex gap-2">
                        <img src="/images/flags/en.svg" alt="" class="w-5 h-auto flex-shrink-0" />
                        <a>English</a>
                    </li>
                    <li class="flex gap-2">
                        <img src="/images/flags/de.svg" alt="" class="w-5 h-auto flex-shrink-0" />
                        <a>German</a>
                    </li>
                </ul>
            </PopoverPanel>
        </Popover>
</template>

<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
</script>
