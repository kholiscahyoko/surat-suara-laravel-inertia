<template>
    <div class="flex flex-wrap justify-center">
        <div v-for="surat_suara in surat_suaras" class="w-64 bg-white rounded-lg overflow-hidden mx-10 shadow-lg mr-4 mb-4">
            <div>
                <div class="bg-red-600 flex justify-between pt-5 px-5 min-h-20">
                    <img v-bind:src="'assets/img/KPU_Logo.svg.webp'" class="w-10 h-11" alt="">
                    <img v-bind:src="'assets/img/Logo_Pemilu_2024.svg.webp'" class="w-10 h-14" alt="">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600">
                    <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
                </svg>
            </div>
            <div class="pt-8 pb-16">
                <h2 class="text-center text-2xl font-bold whitespace-normal">
                    SURAT SUARA
                    <span class="block text-sm">
                        {{ surat_suara.name }}
                    </span>
                </h2>
            </div>
            <div class="min-h-14" :class="surat_suara.color"></div>
        </div>
    </div>
</template>
<script setup>
let surat_suaras = [
        {name : 'PRESIDEN DAN WAKIL PRESIDEN', color : 'bg-gray-600' },
        {name : 'DEWAN PERWAKILAN DAERAH REPUBLIK INDONESIA', color : 'bg-red-600' },
        {name : 'DEWAN PERWAKILAN RAKYAT REPUBLIK INDONESIA', color : 'bg-yellow-600' },
        {name : 'DEWAN PERWAKILAN RAKYAT DAERAH PROVINSI', color : 'bg-blue-600' },
        {name : 'DEWAN PERWAKILAN RAKYAT DAERAH KABUPATEN/KOTA', color : 'bg-green-600' },
    ]
</script>