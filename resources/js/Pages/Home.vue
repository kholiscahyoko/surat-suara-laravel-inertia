<template>
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-4">
        Temukan Siapa Calon Pilihanmu
    </h1>
    <FiturBaru />
    <div class="md:flex md:justify-evenly mb-4 items-center">
        <Link :href="$setUrl('/hitung-suara/pilpres')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 md:p-5 align-middle bg-gray-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Real Count Pilpres</Link>
        <Link :href="$setUrl('/wilayah')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 md:p-5 align-middle bg-red-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Berdasarkan Wilayahmu Disini</Link>
        <Link :href="$setUrl('/dapil')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 md:p-5 align-middle bg-yellow-400 font-semibold text-black rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Berdasarkan Nama Dapil Disini</Link>
        <Link :href="$setUrl('/calon')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5 bg-blue-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Nama Calon Disini</Link>
        <Link :href="$setUrl('/surat-suara/kecamatan/cikande/360415')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5 bg-green-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Contoh Surat Suara Disini</Link>
    </div>
    <StatsBlock v-if="summary" :summary="summary"/>
    <Leaflet v-if="summary && summary.data_provinsi && geo_provinsi" :data_provinsi="summary.data_provinsi" :geo_provinsi="geo_provinsi"/>
    <KawalPemilu />
</template>
<script setup>
import StatsBlock from '../Components/StatsBlock.vue';
import Leaflet from '../Components/Leaflet.vue';
import KawalPemilu from '../Shared/KawalPemilu.vue';
import FiturBaru from '../Shared/FiturBaru.vue';

let props = defineProps({
    summary : Object,
    geo_provinsi: Object,
})
</script>