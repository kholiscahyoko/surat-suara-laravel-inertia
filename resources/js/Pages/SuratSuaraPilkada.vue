<template>
    <div class="md:flex md:justify-between">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Surat Suara Pilkada {{ wilayah.title }}
      </h1>
    </div>
    <SuratSuaraPilkada :paslons="paslons" :wilayah="wilayah"/>
    <FloatShare/>
</template>
<script setup>
import SuratSuaraPilkada from '../Shared/SuratSuaraPilkada.vue';
import FloatShare from '../Shared/FloatShare.vue';

let props = defineProps({
    paslons: Object,
    wilayah: Object,
})

</script>