<template>
    <a v-if="link.url"
        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold"
        v-html="link.label"
        :href="link.url"
        :class="[link.active ? 'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0']"
    />
    <span v-else v-html="link.label" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0" />
</template>

<script setup>
defineProps({
    link: Object
})
</script>