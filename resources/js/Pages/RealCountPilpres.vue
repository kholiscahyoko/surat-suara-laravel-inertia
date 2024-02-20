<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Hasil Hitung Suara Capres dan Cawapres
    </h1>
    <RealCountPilpres :data="data" :master="master" :wilayah="wilayah" />
</template>
<script setup>

let props = defineProps({
    data : Object,
    master : Object,
    wilayah : Object
});

import RealCountPilpres from '../Shared/RealCountPilpres.vue';
</script>