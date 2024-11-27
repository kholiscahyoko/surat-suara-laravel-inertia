<template>
    <div class="md:flex md:justify-between">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Real Count Pilkada {{ wilayah.title }}
      </h1>
    </div>
    <RealCountPilkada :paslons="paslons" :wilayah="wilayah"/>
</template>
<script setup>
import RealCountPilkada from '../Shared/RealCountPilkada.vue';

let props = defineProps({
    paslons: Object,
    wilayah: Object,
})

</script>