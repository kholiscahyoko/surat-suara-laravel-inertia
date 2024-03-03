<template>
  <div class="md:flex md:justify-between">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Calon DPRD Kabupaten / Kota
    </h1>
    <div class="flex">
        <a :href="$setUrl(`/calon-terpilih/${dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-center text-sm px-5 py-2.5 mr-2 mb-3 focus:outline-none">Calon Terpilih</a>
        <a :href="$setUrl(`/hitung-suara/dprd-kabkota/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-center text-sm px-5 py-2.5 mr-2 mb-3 focus:outline-none">Hitung Suara</a>
        <WilayahListBlock :kode_dapil="dapil.kode_dapil"/>
      </div>
  </div>
  <SuratSuaraContentDprdk :partais="partais" :dapil="dapil" :calon_id="calon_id"/>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraContentDprdk from '../Shared/SuratSuaraContentDprdk.vue';
import WilayahListBlock from '../Components/WilayahListBlock.vue'

defineProps({
    'partais' : Object,
    'dapil' : Object,
    'calon_id' : String,
});

onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-green-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-green-600', 'to-white');
})

</script>