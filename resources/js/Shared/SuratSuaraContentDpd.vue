<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mr-4 mb-10 border border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="'assets/img/KPU_Logo.svg.webp'" class="w-10 w-12 lg:w-20 lg:h-20" alt="">
                <div class="block text-center font-bold lg:text-xl">
                    <h3 class="text-white">
                        SURAT SUARA PEMILIHAN UMUM<br>
                        ANGGOTA DEWAN PERWAKILAN DAERAH<br>
                        REPUBLIK INDONESIA<br>
                        TAHUN 2024
                    </h3>
                </div>
                <img v-bind:src="'assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg'" class="w-10 w-12 lg:w-20 lg:h-28" alt="">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold lg:text-xl">
                DAERAH PEMILIHAN<br>
                JAWA TIMUR
            </h3>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-8">
            <div v-for="calon in calons" class="w-32 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border border-2 border-slate-950">
                <div class="text-center px-4 py-4 border-b border-black font-bold text-4xl">
                    {{ calon.no }}
                </div>
                <div>
                    <img v-bind:src="'assets/img/36_3_ADE YULIASIH.webp'" alt="">
                </div>
                <div class="text-center px-4 py-4 border-b min-h-24 border-black text-sm text-wrap break-words">
                    {{ calon.name }}
                </div>
            </div>
            <div class="min-w-32 bg-white overflow-hidden m-2 mb-10">
                <img v-bind:src="'assets/img/sura_dan_sulu-01.webp'" alt="">
            </div>
        </div>
    </div>
</template>
<script setup>
let calons = [
    { name : 'ANTONIOS NIKOPOLIDIS', no : 1 },
    { name : 'GIOURKAS SEITARIDIS', no : 2 },
    { name : 'STYLIANOS VENETIDIS', no : 3 },
    { name : 'NIKOS DABIZAS', no : 4 },
    { name : 'TRAIANOS DELLAS', no : 5 },
    { name : 'ANGELOS BASINAS', no : 6 },
    { name : 'THEODOROS ZAGORAKIS', no : 7 },
    { name : 'STELIOS GIANNAKOPOULOS', no : 8 },
    { name : 'ANGELOS CHARISTEAS', no : 9 },
    { name : 'VASILLOS TSIARTAS', no : 10 },
    { name : 'DEMIS NIKOLAIDIS', no : 11 },
]
</script>