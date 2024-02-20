<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Hasil Hitung Suara Dewan Perwakilan Daerah
    </h1>
    <RealCountDpd :data="data" :master="master" :wilayah="wilayah" :dapil="dapil" />
</template>
<script setup>
import RealCountDpd from '../Shared/RealCountDpd.vue';

let props = defineProps({
    data : Object,
    master : Object,
    wilayah : Object,
    dapil: Object,
});

</script>