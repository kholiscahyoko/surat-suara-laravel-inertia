<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mr-4 mb-10 border border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 pb-2 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="object-contain w-10 w-12 lg:w-28 lg:h-28" alt="Komisi Pemilihan Umum">
                <div class="block text-center font-bold lg:text-2xl">
                    <h3 class="text-white">
                        SURAT SUARA PEMILIHAN UMUM<br>
                        ANGGOTA DEWAN PERWAKILAN RAKYAT<br>
                        REPUBLIK INDONESIA<br>
                        TAHUN 2024
                    </h3>
                </div>
                <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg')" class="object-contain w-10 w-12 lg:w-28 lg:h-28" alt="Pemilu Sarana Integrasi Bangsa">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold lg:text-2xl">
                DAERAH PEMILIHAN<br>
                {{ dapil.nama_dapil }}
            </h3>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-8">
            <CalonDewanBlock v-for="partai in partais" :partai="partai" />
            <div class="min-w-64 bg-white overflow-hidden m-2 mb-10">
                <img v-bind:src="$setUrl('/assets/img/sura_dan_sulu-01.webp')" alt="Sura dan Sulu">
            </div>
        </div>
    </div>
</template>
<script setup>
import CalonDewanBlock from '../Components/CalonDewanBlock.vue';

let props = defineProps({
    partais : Object,
    dapil : Object,
})
</script>