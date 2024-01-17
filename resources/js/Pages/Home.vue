<template>
    <Head>
        <title>Home</title>
        <meta name="description" content="Home Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Welcome
    </h1>
    <SuratSuara />
    <SuratSuaraPilpres />
    <SuratSuaraContentDewan />
</template>
<script setup>
import SuratSuara from '../Shared/SuratSuara.vue';
import SuratSuaraContentDewan from '../Shared/SuratSuaraContentDewan.vue';
import SuratSuaraPilpres from '../Shared/SuratSuaraPilpres.vue';
</script>