<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 w-full">
        <div>
            <h3 class="text-center font-bold md:text-3xl mt-10">
                PEMILIHAN UMUM<br>
                DEWAN PERWAKILAN RAKYAT DAERAH<br>
                {{ prependIfNot('kota', replaceLastWord(dapil.nama_dapil), 'KABUPATEN ') }}<br>
                TAHUN 2024
            </h3>
            <h4 class="text-center font-bold md:text-3xl mt-10">
                DAERAH PEMILIHAN<br>{{ dapil?.nama_dapil }}
            </h4>
        </div>
        <div v-if="data.length <= 0" class="my-8">
            <h3 class="text-xl text-center">Maaf, data tidak tersedia</h3>
            <div class="flex justify-center my-8 w-full">
                <a :href="$setUrl(`/dapil`)" class="my-2 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Dapil Lain Disini</a>
            </div>
        </div>
        <div v-else>
            <div class="text-center my-8">
                {{ data.mode === 'hr' ? `Progress: ${(data.persen).toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2})}%`:`Progress: ${data.progres.progres.toLocaleString('en-US', { style: 'decimal',})} dari ${data.progres.total.toLocaleString('en-US', { style: 'decimal',})} TPS (${((data.progres.progres/data.progres.total)*100).toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2})}%)` }}<br>
                {{ `Diperbarui: ${getFormattedDate(data.ts)}` }}<br>
                <SumberPemilu2024 /><br>
            </div>
            <h2 class="text-center font-bold md:text-3xl mt-10">JUMLAH KURSI TERSEDIA</h2>
            <h2 class="text-center font-bold text-2xl md:text-5xl mt-2">{{ kursi_dapil.jumlah_kursi }}</h2>
            <div class="my-8">
                <HorizontalAds1 />
            </div>
            <h2 class="text-center font-bold md:text-3xl mt-10">PARTAI YANG LOLOS PARLEMEN</h2>
            <h3 class="text-center text-sm md:text-xl mt-1">*menggunakan <a href="https://www.google.com/search?q=sainte+lague" target="_blank" rel="nofollow" class="hover:underline">metode sainte lague</a></h3>
            <div class="flex flex-wrap items-start justify-center mt-2 p-2">
                <KursiPartaiBlock v-for="item, k in data?.list" :partai="master_partai[k]" :data="item"/>
            </div>
            <div class="my-8">
                <HorizontalAds2 />
            </div>
            <h2 class="text-center font-bold md:text-3xl mt-10">CALON YANG KEMUNGKINAN TERPILIH</h2>
            <h3 class="text-center text-sm md:text-xl mt-1">*berdasarkan raihan suara calon</h3>
            <div class="flex flex-wrap items-start justify-center mt-2 p-2">
                <template v-for="item, k in data?.list">
                    <CalonLolosDewanBlock v-for="calon in item.list" :calon="calon" :partai_no_urut="k" :partai="master_partai[k]"/>
                </template>
            </div>
            <div class="md:flex md:justify-evenly mb-4 items-center">
                <a :href="$setUrl(`/hitung-suara/dprd-kabkota/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Real Count Lengkap Disini</a>
                <a :href="$setUrl(`/surat-suara/dprd-kabkota/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Lihat Surat Suara Disini</a>
            </div>

        </div>
    </div>
</template>
<script setup>
import CalonLolosDewanBlock from '../Components/CalonLolosDewanBlock.vue';
import HorizontalAds1 from '../Components/HorizontalAds1.vue';
import HorizontalAds2 from '../Components/HorizontalAds2.vue';
import KursiPartaiBlock from '../Components/KursiPartaiBlock.vue';
import SumberPemilu2024 from './SumberPemilu2024.vue';

let props = defineProps({
    data : Object,
    dapil: Object,
    master_partai: Object,
    kursi_dapil: Object,
});

// Array of month names
const months = [
    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
];

const getFormattedDate = function(dateString){
    // Create a new Date object from the given string
    const date = new Date(dateString);

    // Get the day, month, and year components
    const day = date.getDate();
    const monthIndex = date.getMonth();
    const year = date.getFullYear();

    // Format the date string
    const formattedDate = `${day} ${months[monthIndex]} ${year} ${date.toLocaleTimeString('en-US', { hour12: false })}`;

    return formattedDate;
}

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