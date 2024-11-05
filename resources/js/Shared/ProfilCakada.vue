<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="z-20 object-contain w-12 lg:w-32 lg:h-32" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold lg:text-4xl">
                    <h2 class="text-white">
                        PROFIL CALON
                        <span class="block lg:text-3xl" v-html="calon.type" />
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
                <a :href="calon.paslon_url" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 text-center focus:outline-none">Lihat Visi Misi</a>
                <a :href="wilayah.url" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 text-center focus:outline-none">Lihat Surat Suara</a>
            </div>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-4">
            <ProfilCakadaBlock :calon="calon"/>
            <div class="w-full px-3 text-sm">
            </div>
            <div class="w-full min-h-max rounded-lg bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 duration-300 cursor-pointer p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 justify-items-center mb-4">
                    <div class="text-center p-1">
                        <h5 class="font-bold">Tempat, Tanggal Lahir</h5>
                        <div class="inline-block">{{ calon.details['Tempat, Tanggal Lahir'] }}</div>
                    </div>
                    <div class="text-center p-1">
                        <div class="font-bold">Jenis Kelamin</div>
                        <h4 v-html="calon.details['Jenis Kelamin']"></h4>
                    </div>
                    <div class="text-center p-1">
                        <div class="font-bold">Alamat</div>
                        <h4>{{ calon.details.Alamat }}</h4>
                    </div>
                    <div class="text-center p-1">
                        <div class="font-bold">Agama</div>
                        <h4>{{ calon.details.Agama }}</h4>
                    </div>
                    <div class="text-center p-1">
                        <div class="font-bold">Pendidikan Terakhir</div>
                        <h4>{{ calon.details['Pendidikan Terakhir'] }}</h4>
                    </div>
                </div>
                <TableRiwayatCakadaBlock v-if="calon.riwayat_pendidikan && calon.riwayat_pendidikan.length >= 1" :data_riwayat="calon.riwayat_pendidikan" :title="'RIWAYAT PENDIDIKAN'"/>
                <TableRiwayatCakadaBlock v-if="calon.riwayat_kursus_diklat && calon.riwayat_kursus_diklat.length >= 1" :data_riwayat="calon.riwayat_kursus_diklat" :title="'RIWAYAT KURSUS/DIKLAT'"/>
                <TableRiwayatCakadaBlock v-if="calon.riwayat_organisasi && calon.riwayat_organisasi.length >= 1" :data_riwayat="calon.riwayat_organisasi" :title="'RIWAYAT ORGANISASI'"/>
                <TableRiwayatCakadaBlock v-if="calon.riwayat_tanda_penghargaan && calon.riwayat_tanda_penghargaan.length >= 1" :data_riwayat="calon.riwayat_tanda_penghargaan" :title="'RIWAYAT PENGHARGAAN'"/>
                <TableRiwayatCakadaBlock v-if="calon.riwayat_publikasi && calon.riwayat_publikasi.length >= 1" :data_riwayat="calon.riwayat_publikasi" :title="'RIWAYAT PUBLIKASI'"/>
                <div>
                    <p class="font-semibold">Sumber Data</p>
                    <p>
                        <a href="https://infopemilu.kpu.go.id/Pemilihan/Pilkada" rel="nofollow" target="_blank" class="text-indigo-600 hover:text-indigo-900">Info Pemilu KPU</a>, terakhir akses tanggal 28 Oktober 2024
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
import ProfilCakadaBlock from '../Components/ProfilCakadaBlock.vue';
import Donations from '../Components/Donations.vue';
import TableRiwayatCakadaBlock from '../Components/TableRiwayatCakadaBlock.vue';

let props = defineProps({
    calon: Object,
    wilayah: Object,
})
</script>