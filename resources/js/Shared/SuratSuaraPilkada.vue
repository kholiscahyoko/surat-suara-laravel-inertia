<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="z-20 object-contain w-12 md:w-24 md:h-24 lg:w-32 lg:h-32" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold text-xl md:text-4xl lg:text-6xl">
                    <h3 class="text-white">
                        SURAT SUARA
                    </h3>
                </div>
                <img :src="wilayah.image_url" class="z-20 object-contain w-12  md:w-24 md:h-24 lg:w-32 lg:h-32" :alt="wilayah.title">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold md:text-3xl lg:text-5xl">
                PEMILIHAN<br>
                {{ paslons.type }}<br>
                {{ wilayah.title }}<br>
                TAHUN 2024
            </h3>
            <div class="mt-8 text-center">
                <a v-if="paslons.realcount_url" :href="paslons.realcount_url" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-center text-sm px-5 py-2.5 mr-2 mb-3 focus:outline-none">Lihat Real Count</a>
            </div>

        </div>
        <div class="flex flex-wrap items-start justify-center mt-8">
            <PilkadaBlock v-for="paslon in paslons.data" :paslon="paslon" :jumlah_paslon="paslons.data.length"/>
        </div>
    </div>
</template>
<script setup>
import PilkadaBlock from '../Components/PilkadaBlock.vue';
let props = defineProps({
    paslons: Object,
    wilayah: Object,
})
</script>