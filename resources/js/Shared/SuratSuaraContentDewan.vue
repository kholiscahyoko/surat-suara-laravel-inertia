<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mr-4 mb-10 border border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 pb-2 px-5 min-h-20">
                <img v-bind:src="'/assets/img/logo-kpu.webp'" class="object-contain w-10 w-12 lg:w-28 lg:h-28" alt="">
                <div class="block text-center font-bold lg:text-2xl">
                    <h3 class="text-white">
                        SURAT SUARA PEMILIHAN UMUM<br>
                        ANGGOTA DEWAN PERWAKILAN RAKYAT DAERAH<br>
                        KABUPATEN GRESIK<br>
                        TAHUN 2024
                    </h3>
                </div>
                <img v-bind:src="'/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg'" class="object-contain w-10 w-12 lg:w-28 lg:h-28" alt="">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold lg:text-2xl">
                DAERAH PEMILIHAN<br>
                GRESIK 1
            </h3>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-8">
            <div v-for="surat_suara in surat_suaras" class="w-64 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border border-2 border-slate-950">
                <div class="flex items-center px-4 py-4 border-b border-black">
                    <div class="font-bold w-10 h-5 text-3xl text-center">{{ surat_suara.no }}</div>
                    <img v-bind:src="`assets/img/partai/${surat_suara.no}.webp`" class="w-20 h-20 mx-2 object-contain" alt="">
                    <div class="font-semibold text-wrap text-sm">{{ surat_suara.name }}</div>
                </div>
                <table class="min-w-full">
                    <tbody class="divide-y divide-dashed divide-gray-600">
                        <tr v-for="calon in calons">
                            <td class="p-2 w-1/12">{{ calon.no }}.</td>
                            <td class="p-2 text-sm">{{ calon.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="min-w-64 bg-white overflow-hidden m-2 mb-10">
                <img v-bind:src="'/assets/img/sura_dan_sulu-01.webp'" alt="">
            </div>
        </div>
    </div>
</template>
<script setup>
let surat_suaras = [
    { name : 'PARTAI KEBANGKITAN BANGSA', no : 1 },
    { name : 'PARTAI GERINDRA', no : 2 },
    { name : 'PDI PERJUANGAN', no : 3 },
    { name : 'PARTAI GOLKAR', no : 4 },
    { name : 'Partai NasDem', no : 5 },
    { name : 'PARTAI BURUH', no : 6 },
    { name : 'PARTAI GELORA', no : 7 },
    { name : 'PARTAI KEADILAN SEJAHTERA', no : 8 },
    { name : 'PARTAI KEBANGKITAN NASIONAL', no : 9 },
    { name : 'PARTAI HANURA', no : 10 },
    { name : 'PARTAI GARUDA', no : 11 },
    { name : 'PARTAI AMANAT NASIONAL', no : 12 },
    { name : 'PARTAI BULAN BINTANG', no : 13 },
    { name : 'PARTAI DEMOKRAT', no : 14 },
    { name : 'PARTAI SOLIDARITAS INDONESIA', no : 15 },
    { name : 'PARTAI PERINDO', no : 16 },
    { name : 'PARTAI PERSATUAN PEMBANGUNAN', no : 17 },
    { name : 'PARTAI NANGGROE ACEH', no : 18 },
    { name : 'PARTAI BENDERA', no : 19 },
    { name : 'PARTAI DARUL ACEH', no : 20 },
    { name : 'PARTAI ACEH', no : 21 },
    { name : 'PARTAI ADIL SEJAHTERA', no : 22 },
    { name : 'PARTAI SIRA', no : 23 },
    { name : 'PARTAI UMMAT', no : 24 },
]

let calons = [
    { name : 'LEONARDO', no : 1 },
    { name : 'RAPHAEL', no : 2 },
    { name : 'DONATELLO', no : 3 },
    { name : 'MICHELANGELO', no : 4 },
]
</script>