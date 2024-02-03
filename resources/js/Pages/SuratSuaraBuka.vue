<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Surat Suara Wilayah
    </h1>
    <SuratSuaraContentDpd v-if="dpd" :calons="dpd.surat_suara" :dapil="dpd.dapil"/>
    <SuratSuaraContentDpr v-if="dpr" :partais="dpr.surat_suara" :dapil="dpr.dapil"/>
    <SuratSuaraContentDprdp v-if="dprdp" :partais="dprdp.surat_suara" :dapil="dprdp.dapil"/>
    <SuratSuaraContentDprdk v-if="dprdk" :partais="dprdk.surat_suara" :dapil="dprdk.dapil"/>
</template>
<script setup>
import SuratSuaraContentDpd from '../Shared/SuratSuaraContentDpd.vue';
import SuratSuaraContentDpr from '../Shared/SuratSuaraContentDpr.vue';
import SuratSuaraContentDprdp from '../Shared/SuratSuaraContentDprdp.vue';
import SuratSuaraContentDprdk from '../Shared/SuratSuaraContentDprdk.vue';

defineProps({
    'dprdk' : Object,
    'dprdp' : Object,
    'dpr' : Object,
    'dpd' : Object
});
</script>