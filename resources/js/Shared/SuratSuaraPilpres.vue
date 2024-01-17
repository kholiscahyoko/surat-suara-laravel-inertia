<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mr-4 mb-10 border border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="'/assets/img/logo-kpu.webp.webp'" class="z-20 object-contain w-10 w-12 lg:w-32 lg:h-32" alt="">
                <div class="block text-center font-bold lg:text-6xl">
                    <h3 class="text-white">
                        SURAT SUARA
                    </h3>
                </div>
                <img v-bind:src="'/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg'" class="z-20 object-contain w-10 w-12 lg:w-32 lg:h-32" alt="">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold lg:text-5xl">
                PEMILIHAN UMUN<br>
                PRESIDEN DAN WAKIL PRESIDEN<br>
                REPUBLIK INDONESIA<br>
                TAHUN 2024
            </h3>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-8">
            <PilpresBlock v-for="calon in calons" :calon="calon"/>
            <div class="min-w-32 bg-white overflow-hidden m-2 mb-10">
                <img v-bind:src="'/assets/img/sura_dan_sulu-01.webp'" alt="">
            </div>
        </div>
    </div>
</template>
<script setup>
import PilpresBlock from '../Components/PilpresBlock.vue';

let calons = [
    { no: 1, capres : 'H. ANIES RASYID BASWEDAN, Ph.D', cawapres : 'H. A. MUHAIMIN ISKANDAR, Dr. (H.C.)', partai : [5, 1, 8] },
    { no: 2, capres : 'H. PRABOWO SUBIANTO', cawapres : 'GIBRAN RAKABUMING RAKA', partai : [2, 4, 14, 12, 15, 13, 11] },
    { no: 3, capres : 'H. GANJAR PRANOWO, S.H., M.I.P.', cawapres : 'Prof. Dr. H. M. MAHFUD MD', partai : [3, 17, 10, 16] }
]
</script>