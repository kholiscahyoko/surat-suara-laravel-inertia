<template>
    <div class="md:flex md:justify-between">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Visi Misi dan Laporan Kampanye {{ paslon.nama }}
      </h1>
    </div>
    <PasanganCakada :paslon="paslon" :wilayah="wilayah" />
</template>

<script setup>
import PasanganCakada from '../Shared/PasanganCakada.vue';

let props = defineProps({
    paslon: Object,
    wilayah: Object,
})

</script>