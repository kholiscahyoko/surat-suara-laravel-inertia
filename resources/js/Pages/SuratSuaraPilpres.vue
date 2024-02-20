<template>
    <div class="md:flex md:justify-between">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Surat Suara Capres dan Cawapres
      </h1>
      <div class="flex">
        <a :href="$setUrl(`/hitung-suara/pilpres`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-3 focus:outline-none">Hitung Suara</a>
      </div>
    </div>
    <SuratSuaraPilpres />
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraPilpres from '../Shared/SuratSuaraPilpres.vue';

onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-gray-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-gray-600', 'to-white');
})

</script>