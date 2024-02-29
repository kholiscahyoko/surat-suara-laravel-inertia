<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 w-full">
        <div>
            <h3 class="text-center font-bold md:text-3xl mt-10">
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
            {{ `Progress: ${data.progres.progres.toLocaleString('en-US', { style: 'decimal',})} dari ${data.progres.total.toLocaleString('en-US', { style: 'decimal',})} TPS (${((data.progres.progres/data.progres.total)*100).toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2})}%)` }}<br>
            {{ `Diperbarui: ${getFormattedDate(data.ts)}` }}<br>
            <SumberPemilu2024 /><br>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-8 space-x-4 p-2">
            <CalonLolosDpdBlock v-for="calon in data.list" :calon="calon" />
        </div>
        <div class="md:flex md:justify-evenly mb-4 items-center">
            <a :href="$setUrl(`/hitung-suara/dpd/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Real Count Lengkap Disini</a>
            <a :href="$setUrl(`/surat-suara/dpd/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}`)" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Lihat Surat Suara Disini</a>
        </div>
    </div>
</template>
<script setup>
import CalonLolosDpdBlock from '../Components/CalonLolosDpdBlock.vue';
import SumberPemilu2024 from './SumberPemilu2024.vue';

let props = defineProps({
    data : Object,
    dapil: Object,
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