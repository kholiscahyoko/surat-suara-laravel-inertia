<template>
    <Head>
        <title>Calon DPD RI</title>
        <meta name="description" content="DPD Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Calon DPD RI
    </h1>
    <SuratSuaraContentDpd :calons="calons" :dapil="dapil" :calon_id="calon_id"/>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraContentDpd from '../Shared/SuratSuaraContentDpd.vue';

defineProps({
    'calons' : Object,
    'dapil' : Object,
    'calon_id' : String
});
onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-red-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-red-600', 'to-white');
})

</script>