<template>
    <div class="md:flex md:justify-between">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
          Calon DPRD Provinsi
      </h1>
      <WilayahListBlock :kode_dapil="dapil.kode_dapil"/>
    </div>
    <SuratSuaraContentDprdp :partais="partais" :dapil="dapil" :calon_id="calon_id"/>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraContentDprdp from '../Shared/SuratSuaraContentDprdp.vue';
import WilayahListBlock from '../Components/WilayahListBlock.vue';

defineProps({
    'partais' : Object,
    'dapil' : Object,
    'calon_id' : String
});

onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-blue-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-blue-600', 'to-white');
})

</script>