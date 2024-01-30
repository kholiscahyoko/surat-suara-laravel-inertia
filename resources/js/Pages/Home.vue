<template>
    <Head>
        <title>Halaman Utama</title>
        <meta name="description" content="Home Information" head-key="meta-description">
    </Head>
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-4">
        Temukan Siapa Calon Pilihanmu
    </h1>
    <div class="lg:flex lg:justify-evenly mb-4 items-center">
        <Link :href="$setUrl('/wilayah')" class="block my-5 mx-20 lg:mx-2 text-center text-lg lg:text-xl lg:w-50 p-2 lg:p-5 align-middle bg-red-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Berdasarkan Wilayahmu Disini</Link>
        <Link :href="$setUrl('/dapil')" class="block my-5 mx-20 lg:mx-2 text-center text-lg lg:text-xl lg:w-50 p-2 lg:p-5 align-middle bg-yellow-400 font-semibold text-black rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Berdasarkan Nama Dapil Disini</Link>
        <Link :href="$setUrl('/calon')" class="block my-5 mx-20 lg:mx-2 text-center text-lg lg:text-xl lg:w-50 p-2 align-middle lg:p-5 bg-blue-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Nama Calon Disini</Link>
    </div>
    <StatsBlock v-if="summary" :summary="summary"/>
    <Leaflet v-if="summary && summary.data_provinsi" :data_provinsi="summary.data_provinsi"/>
</template>
<script setup>
import StatsBlock from '../Components/StatsBlock.vue';
import Leaflet from '../Components/Leaflet.vue';

let props = defineProps({
    summary : Object
})
</script>