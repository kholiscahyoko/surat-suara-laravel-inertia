<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950">
        <div>
            <div class="flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="z-20 object-contain w-12 md:w-24 md:h-24 lg:w-32 lg:h-32" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold text-xl md:text-4xl">
                    <h3>
                        HITUNG SUARA
                    </h3>
                </div>
                <img :src="wilayah.image_url" class="z-20 object-contain w-12  md:w-24 md:h-24 lg:w-32 lg:h-32" :alt="wilayah.title">
            </div>
            <h3 class="text-center font-bold md:text-3xl">
                PEMILIHAN<br>
                {{ paslons.type }}<br>
                {{ wilayah.title }}<br>
                TAHUN 2024
            </h3>
        </div>
        <div class="text-center my-8">
            {{ `Progress: ${paslons.progres.progres.toLocaleString('en-US', { style: 'decimal',})} dari ${paslons.progres.total.toLocaleString('en-US', { style: 'decimal',})} TPS (${((paslons.progres.progres/paslons.progres.total)*100).toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2})}%)` }}
            {{ `Diperbarui: ${getFormattedDate(paslons.ts)}` }}<br>
            <span class="font-semibold">Sumber Data</span>: <a href="https://pilkada2024.kpu.go.id" rel="nofollow" target="_blank" class="text-indigo-600 hover:text-indigo-900">pilkada2024.kpu.go.id</a><br>
            <span class="font-semibold">Disclaimer</span>: Tidak termasuk pemungutan suara ulang (jika ada)<br>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-8">
            <RealCountPilkadaBlock v-for="paslon in paslons.data" :paslon="paslon" :jumlah_paslon="paslons.data.length" :total_suara="paslons.total_suara"/>
        </div>
        <div class="md:flex md:justify-evenly mb-4 items-center">
            <a :href="paslons.surat_suara_url" class="block my-5 mx-20 md:mx-2 text-center text-lg lg:text-xl md:w-50 p-2 align-middle md:p-5  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Lihat Surat Suara Disini</a>
        </div>
    </div>
</template>
<script setup>
import RealCountPilkadaBlock from '../Components/RealCountPilkadaBlock.vue';
let props = defineProps({
    paslons: Object,
    wilayah: Object,
})

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