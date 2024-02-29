<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 w-full">
        <div>
            <h3 class="text-center font-bold md:text-3xl mt-10">
                HITUNG SUARA<br>
                PEMILIHAN UMUM<br>
                DEWAN PERWAKILAN RAKYAT<br>
                REPUBLIK INDONESIA<br>
                TAHUN 2024
            </h3>
            <h4 class="text-center font-bold md:text-3xl mt-10">
                DAERAH PEMILIHAN<br>{{ dapil.nama_dapil }}
            </h4>
        </div>
        <div class="my-8">
            <BarChartPartai v-if="higher_data.chart" :master="master_partai" :data="higher_data" :nasional="true" :id="`nasional`"/>
        </div>
        <div class="my-8">
            <BarChartPartai v-if="lower_data.chart" :master="master_partai" :data="lower_data" :nasional="false" :id="`daerah`" :dapil="dapil"/>
        </div>
        <div class="my-8">
            <h5 class="text-center font-bold md:text-2xl mt-10">Perolehan Suara Calon Legislatif</h5>
            <div class="text-center mb-4"><SumberPemilu2024 /></div>
            <div class="flex flex-wrap items-start justify-center">
                <TableSuaraCaleg v-if="lower_data.table" v-for="calon_data, no_urut in master_calon" :partai="master_partai[no_urut]" :master_calon="calon_data" :calon="calon" :data="lower_data.table[no_urut]" :dapil="dapil" :key="no_urut"/>
            </div>
        </div>
    </div>
</template>
<script setup>
import BarChartPartai from '../Components/BarChartPartai.vue';
import TableSuaraCaleg from '../Components/TableSuaraCaleg.vue';
import SumberPemilu2024 from './SumberPemilu2024.vue';

let props = defineProps({
    master_partai : Object,
    master_calon : Object,
    higher_data : Object,
    lower_data : Object,
    dapil: Object,
    calon: Object,
});

</script>