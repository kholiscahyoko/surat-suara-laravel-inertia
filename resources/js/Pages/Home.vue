<template>
    <Head>
        <title>Home</title>
        <meta name="description" content="Home Information" head-key="meta-description">
    </Head>
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-4">
        Temukan Siapa Calon Pilihanmu
    </h1>
    <div class="lg:flex lg:justify-evenly mb-20 items-center">
        <Link href="/wilayah" class="block my-5 mx-20 lg:mx-2 text-center text-lg lg:text-xl lg:w-50 p-2 lg:p-5 align-middle bg-red-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Berdasarkan Wilayahmu Disini</Link>
        <Link href="/dapil" class="block my-5 mx-20 lg:mx-2 text-center text-lg lg:text-xl lg:w-50 p-2 lg:p-5 align-middle bg-yellow-500 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Berdasarkan Nama Dapil Disini</Link>
        <Link href="/calon" class="block my-5 mx-20 lg:mx-2 text-center text-lg lg:text-xl lg:w-50 p-2 align-middle lg:p-5 bg-blue-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Cari Nama Calon Disini</Link>
    </div>
    <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-4">Contoh Surat Suara</h2>
    <SuratSuara />
    <SuratSuaraPilpres />
    <SuratSuaraContentDewan />
</template>
<script setup>
import SuratSuara from '../Shared/SuratSuara.vue';
import SuratSuaraContentDewan from '../Shared/SuratSuaraContentDewan.vue';
import SuratSuaraPilpres from '../Shared/SuratSuaraPilpres.vue';
</script>