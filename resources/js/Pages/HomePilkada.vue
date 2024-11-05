<template>
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-4">
        Temukan Calon Kepala Daerahmu Disini
    </h1>
    <div class="text-lg">Perlu Bantuan ? <a :href="$setUrl('/hubungi-kami')" class="hover:underline text-indigo-600 font-semibold">Hubungi Kami</a></div>
    <div class="md:flex md:justify-evenly mb-4 items-center">
        <a :href="$setUrl('/cari')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5 bg-gradient-to-r from-red-700 via-green-700 to-blue-700 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Semua Disini</a>
        <a :href="$setUrl('/pilkada/wilayah')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 md:p-5 align-middle bg-red-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Berdasarkan Wilayahmu Disini</a>
        <a :href="$setUrl('/pilkada/calon')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 md:p-5 align-middle bg-yellow-300 font-semibold text-black rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Calon Kepala Daerah Disini</a>
        <a :href="$setUrl('/pilkada/surat-suara/gubernur-dan-wakil-gubernur/banten/36')" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5 bg-green-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Contoh Surat Suara</a>
    </div>
    <div class="w-full">
        <HorizontalAds1/>
    </div>
    <Donations />
</template>
<script setup>
import HorizontalAds1 from '../Components/HorizontalAds1.vue';
import Donations from '../Components/Donations.vue';
</script>