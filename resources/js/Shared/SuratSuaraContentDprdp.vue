<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 pb-2 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="object-contain w-12 md:w-28 md:h-28" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold md:text-lg lg:text-2xl">
                    <h3 class="text-white">
                        SURAT SUARA PEMILIHAN UMUM<br>
                        ANGGOTA DEWAN PERWAKILAN RAKYAT DAERAH<br>
                        PROVINSI {{ replaceLastWord(dapil.nama_dapil) }}<br>
                        TAHUN 2024
                    </h3>
                </div>
                <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg')" class="object-contain w-12 md:w-28 md:h-28" alt="Pemilu Sarana Integrasi Bangsa" loading="lazy">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold md:text-2xl">
                DAERAH PEMILIHAN<br>
                {{ dapil.nama_dapil }}
            </h3>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-8">
            <CalonDewanBlock v-for="partai in partais" :partai="partai" :calon_id="calon_id" :dapil="dapil"/>
            <div class="min-w-64 bg-white overflow-hidden m-2 mb-10">
                <img v-bind:src="$setUrl('/assets/img/sura_dan_sulu-01.webp')" alt="Sura dan Sulu" loading="lazy">
            </div>
        </div>
    </div>
</template>
<script setup>
import CalonDewanBlock from '../Components/CalonDewanBlock.vue';

let props = defineProps({
    partais : Object,
    dapil : Object,
    calon_id: String
})

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
</script>