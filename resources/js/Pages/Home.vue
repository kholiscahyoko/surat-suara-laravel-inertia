<template>
    <Head>
        <title>Home</title>
        <meta name="description" content="Home Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Welcome
    </h1>
    <SuratSuara />
    <SuratSuaraContentDewan />
    <SuratSuaraContentDpd />
</template>
<script setup>
import SuratSuara from '../Shared/SuratSuara.vue';
import SuratSuaraContentDewan from '../Shared/SuratSuaraContentDewan.vue';
import SuratSuaraContentDpd from '../Shared/SuratSuaraContentDpd.vue';
</script>