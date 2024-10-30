<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="z-20 object-contain w-12 lg:w-32 lg:h-32" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold lg:text-4xl">
                    <h2 class="text-white">
                        PASANGAN CALON
                        <span class="block lg:text-3xl" v-html="paslon.type" />
                    </h2>
                </div>
                <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg')" class="z-20 object-contain w-12 lg:w-32 lg:h-32" alt="Pemilu Sarana Integrasi Bangsa" loading="lazy">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold lg:text-4xl">
                PEMILIHAN KEPALA DAERAH<br>
                <span class="block lg:text-3xl">{{ wilayah.title }}</span>
            </h3>
            <div class="flex justify-center flex-wrap align-middle mt-2 space-x-2">
                <a :href="wilayah.url" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 text-center focus:outline-none">Lihat Surat Suara</a>
            </div>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-4">
            <PasanganCakadaBlock :paslon="paslon"/>
            <div class="w-full px-3 text-sm min-h-48 relative bg-cover bg-center " :style="`background-image: url('${paslon.image_url}');`">
                <div class="absolute inset-0 bg-white opacity-90"></div>
                <div class="relative z-10 text-black p-4">
                    <h3 class="text-2xl lg:text-4xl text-center mt-4 font-bold">VISI DAN MISI</h3>
                    <h4 class="text-xl lg:text-2xl mt-4 font-bold">VISI</h4>
                    <div class="text-lg mt-4" v-html="convertToItems(paslon.visi_misi.visi)">
                    </div>
                    <h4 class="text-xl lg:text-2xl mt-4 font-bold">MISI</h4>
                    <div class="text-lg mt-4" v-html="convertToItems(paslon.visi_misi.misi)">
                    </div>
                </div>
            </div>
            <div class="w-full px-3">
                <TableRiwayatCakadaBlock v-if="paslon.agenda_kampanye && paslon.agenda_kampanye.length >= 1" :data_riwayat="paslon.agenda_kampanye" :title="'LAPORAN KAMPANYE'"/>
            </div>
            <div class="w-full min-h-max rounded-lg bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 duration-300 cursor-pointer p-4">
                <div>
                    <p class="font-semibold">Sumber Data</p>
                    <p>
                        <a href="https://infopemilu.kpu.go.id/Pemilu/Peserta_pemilu" rel="nofollow" target="_blank" class="text-indigo-600 hover:text-indigo-900">DCT Info Pemilu KPU</a>, terakhir akses tanggal 18 Januari 2024
                    </p>
                    <p class="text-lg">
                        Perlu Bantuan ? <a :href="$setUrl('/hubungi-kami')" class="hover:underline text-indigo-600 font-semibold">Hubungi Kami</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 pt-4">
        <Donations />
    </div>
</template>
<script setup>
import PasanganCakadaBlock from '../Components/PasanganCakadaBlock.vue';
import TableRiwayatCakadaBlock from '../Components/TableRiwayatCakadaBlock.vue';
import Donations from '../Components/Donations.vue';

let props = defineProps({
    paslon: Object,
    wilayah: Object,
})

function convertToItems(string) {
    // Split the raw text into lines and filter out empty lines
    const lines = string.split(/\r\n/).filter(item => item.trim() !== '');

    // Initialize arrays to hold formatted HTML content
    const listItems = [];
    const paragraphs = [];

    // Process each line
    lines.forEach(line => {
        // Check if the line starts with a number and a period (e.g., "1.", "2.")
        if (/^\d+\.\s*/.test(line)) {
            // Remove the leading number and period, and add to listItems as a list item
            listItems.push(`<li>${line.replace(/^\d+\.\s*/, '')}</li>`);
        } else {
            // If the line is not a list item, add it to paragraphs
            paragraphs.push(`<p>${line}</p>`);
        }
    });

    // Create the output
    let output = '';
    
    // Include paragraphs if there are any
    if (paragraphs.length > 0) {
        output += `
            <div class="space-y-2 text-gray-800">
                ${paragraphs.join('')}
            </div>
        `;
    }

    // Include ordered list if there are any list items
    if (listItems.length > 0) {
        output += `
            <ol class="list-decimal list-inside space-y-2 text-gray-800">
                ${listItems.join('')}
            </ol>
        `;
    }

    return output;
}

</script>