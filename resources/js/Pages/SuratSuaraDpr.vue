<template>
    <div class="md:flex md:justify-between">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
          Calon DPR RI
      </h1>
      <div class="flex">
        <a :href="$setUrl(`/calon-terpilih/${dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-center text-sm px-5 py-2.5 mr-2 mb-3 focus:outline-none">Calon Terpilih</a>
        <a :href="$setUrl(`/hitung-suara/${dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-center text-sm px-5 py-2.5 mr-2 mb-3 focus:outline-none">Hitung Suara</a>
        <WilayahListBlock :kode_dapil="dapil.kode_dapil"/>
      </div>
    </div>
    <SuratSuaraContentDpr :partais="partais" :dapil="dapil" :calon_id="calon_id"/>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraContentDpr from '../Shared/SuratSuaraContentDpr.vue';
import WilayahListBlock from '../Components/WilayahListBlock.vue';

defineProps({
    'partais' : Object,
    'dapil' : Object,
    'calon_id' : String,
});

onMounted(() => {
//   document.body.classList.add('bg-yellow-400');
  document.body.classList.add('bg-gradient-to-tl', 'from-yellow-400', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-yellow-400', 'to-white');
})
</script>