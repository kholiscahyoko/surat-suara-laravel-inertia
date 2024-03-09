<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 w-full">
        <div class="px-4">
            <h3 class="text-center font-bold md:text-3xl mt-10">
                HITUNG SUARA<br>
                PEMILIHAN UMUM<br>
                DEWAN PERWAKILAN RAKYAT DAERAH<br>
                {{ prependIfNot('kota', replaceLastWord(dapil.nama_dapil), 'KABUPATEN ') }}<br>
                TAHUN 2024
            </h3>
            <h4 class="text-center font-bold md:text-3xl mt-10">
                DAERAH PEMILIHAN<br>{{ dapil.nama_dapil }}
            </h4>
        </div>
        <div class="my-8">
            <BarChartPartai v-if="data?.chart" :master="master_partai" :data="data" :nasional="false" :id="`daerah`" :dapil="dapil"/>
        </div>
        <div class="flex justify-center mt-8 w-full">
            <a :href="$setUrl(`/calon-terpilih/${dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="my-2 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Calon Terpilih Disini</a>
        </div>
        <h3 class="text-center text-sm md:text-xl mt-1">*menggunakan <a href="https://www.google.com/search?q=sainte+lague" target="_blank" rel="nofollow" class="hover:underline">metode sainte lague</a></h3>
        <div class="my-8">
            <HorizontalAds1 />
        </div>
        <div class="my-8">
            <h5 class="text-center font-bold md:text-2xl mt-10">Perolehan Suara Calon Legislatif</h5>
            <div class="text-center mb-4"><SumberPemilu2024 /></div>
            <div class="flex flex-wrap items-start justify-center">
                <TableSuaraCaleg v-if="data?.table" v-for="calon_data, no_urut in master_calon" :partai="master_partai[no_urut]" :master_calon="calon_data" :calon="calon" :data="data.table[no_urut]" :dapil="dapil" :key="no_urut"/>
            </div>
        </div>
    </div>
</template>
<script setup>
import BarChartPartai from '../Components/BarChartPartai.vue';
import HorizontalAds1 from '../Components/HorizontalAds1.vue';
import TableSuaraCaleg from '../Components/TableSuaraCaleg.vue';
import SumberPemilu2024 from './SumberPemilu2024.vue';

let props = defineProps({
    master_partai : Object,
    master_calon : Object,
    data : Object,
    dapil: Object,
    calon: Object,
});

function replaceLastWord(inputString) {
    // Regular expression to match a word with 4 or fewer letters at the end of the string
    const regex = /\b\d+\b$/;

    // Find the last word in the string
    const lastWordMatch = inputString.match(regex);

    if (lastWordMatch) {
        const lastWord = lastWordMatch[0];

        if (!isNaN(lastWord)) {
        const modifiedString = inputString.replace(regex, '');
        return modifiedString.trim();
        }
    }

  return inputString;
}

function prependIfNot(wordToCheck, originalString, prefix) {
  const words = originalString.trim().split(' ');
  if (words.length > 0 && words[0].toLowerCase() !== wordToCheck.toLowerCase()) {
    return `${prefix}${originalString}`;
  }
  return originalString;
}
</script>