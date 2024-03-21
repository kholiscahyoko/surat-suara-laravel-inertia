<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 w-full">
        <div>
            <h3 class="text-center font-bold md:text-3xl mt-10">
                HITUNG SUARA<br>
                PEMILIHAN UMUM<br>
                PRESIDEN DAN WAKIL PRESIDEN<br>
                REPUBLIK INDONESIA<br>
                TAHUN 2024
            </h3>
        </div>
        <div class="flex flex-wrap items-start justify-center text-center my-8">
            {{ data.mode !== 'hr' ? `Progress: ${data.progres.progres.toLocaleString('en-US', { style: 'decimal',})} dari ${data.progres.total.toLocaleString('en-US', { style: 'decimal',})} TPS (${((data.progres.progres/data.progres.total)*100).toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2})}%)<br>` : `` }}
            {{ `Diperbarui: ${getFormattedDate(data.ts)}` }}<br>
        </div>
        <div class="flex flex-wrap items-start justify-center my-8">
            <PieChart :master="master" :data="data"/>
        </div>
        <div class="w-full my-8">
            <HorizontalAds1 />
        </div>
        <div class="px-3">
            <TableSuaraPerWilayah  :master="master" :data="data" :wilayah="wilayah"/>
        </div>
    </div>
</template>
<script setup>
import HorizontalAds1 from '../Components/HorizontalAds1.vue';
import PieChart from '../Components/PieChart.vue';
import TableSuaraPerWilayah from '../Components/TableSuaraPerWilayah.vue';

let props = defineProps({
    master : Object,
    data : Object,
    wilayah : Object
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