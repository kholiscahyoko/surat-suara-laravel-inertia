<template>
    <ProfilCakada :calon="calon" :wilayah="wilayah" />
</template>

<script setup>
import ProfilCakada from '../Shared/ProfilCakada.vue';

let props = defineProps({
    calon: Object,
    wilayah: Object,
})

</script>