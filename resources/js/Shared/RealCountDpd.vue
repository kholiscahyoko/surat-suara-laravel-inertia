<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 w-full">
        <div>
            <h3 class="text-center font-bold md:text-3xl mt-10">
                HITUNG SUARA<br>
                PEMILIHAN UMUM<br>
                DEWAN PERWAKILAN DAERAH<br>
                REPUBLIK INDONESIA<br>
                TAHUN 2024
            </h3>
            <h4 class="text-center font-bold md:text-3xl mt-10">
                DAERAH PEMILIHAN<br>{{ dapil.nama_dapil }}
            </h4>
        </div>
        <div class="text-center my-8">
            {{ `Progress: ${data.progres.progres.toLocaleString('en-US', { style: 'decimal',})} dari ${data.progres.total.toLocaleString('en-US', { style: 'decimal',})} TPS (${data.chart.persen}%)` }}<br>
            {{ `Diperbarui: ${getFormattedDate(data.ts)}` }}<br>
            <SumberPemilu2024 /><br>
        </div>
        <div class="flex flex-wrap items-start justify-center my-8">
            <BarChart :master="master" :data="data" :calon="calon"/>
        </div>
        <div class="w-full my-8">
            <HorizontalAds1 />
        </div>
        <div class="flex flex-wrap items-start justify-center my-8">
            <TableSuaraDpdPerWilayah :master="master" :data="data" :wilayah="wilayah" :calon="calon" :dapil="dapil"/>
        </div>
    </div>
</template>
<script setup>
import BarChart from '../Components/BarChart.vue';
import HorizontalAds1 from '../Components/HorizontalAds1.vue';
import TableSuaraDpdPerWilayah from '../Components/TableSuaraDpdPerWilayah.vue';
import SumberPemilu2024 from './SumberPemilu2024.vue';

let props = defineProps({
    master : Object,
    data : Object,
    wilayah : Object,
    dapil: Object,
    calon: Object,
});

// Array of month names
const months = [
    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
];

const getFormattedDate = function(dateString){
    // Create a new Date object from the given string
    const date = new Date(dateString);

    // Get the day, month, and year components
    const day = date.getDate();
    const monthIndex = date.getMonth();
    const year = date.getFullYear();

    // Format the date string
    const formattedDate = `${day} ${months[monthIndex]} ${year} ${date.toLocaleTimeString('en-US', { hour12: false })}`;

    return formattedDate;
}

</script>