<template>
    <back-to-top class="hidden md:block bg-red-500 bg-opacity-95 hover:bg-opacity-80 font-semibold text-white rounded-lg p-2">
        <button type="button" class="">Kembali Ke Atas</button>
    </back-to-top>
    <back-to-top class="md:hidden bg-red-500 bg-opacity-95 hover:bg-opacity-80 font-semibold text-white rounded-lg p-2">
        <button type="button" class="text-xl">
            <ChevronUpIcon class="h-8 w-8" aria-hidden="true"/>
        </button>
    </back-to-top>
</template>
<script setup>
import BackToTop from 'vue-backtotop'
import { ChevronUpIcon } from '@heroicons/vue/24/outline'

</script>