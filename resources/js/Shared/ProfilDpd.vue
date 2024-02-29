<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="z-20 object-contain w-12 lg:w-32 lg:h-32" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold lg:text-4xl">
                    <h2 class="text-white">
                        PROFIL CALON
                        <span class="block lg:text-3xl" v-html="header_title"></span>
                    </h2>
                </div>
                <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg')" class="z-20 object-contain w-12 lg:w-32 lg:h-32" alt="Pemilu Sarana Integrasi Bangsa" loading="lazy">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold lg:text-4xl">
                PROVINSI<br>
                <span class="block lg:text-3xl">{{ calon.dapil.nama_dapil }}</span>
            </h3>
            <div class="flex justify-center align-middle mt-2 space-x-2">
                <a :href="$setUrl(`/hitung-suara/${calon.dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : calon.dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : calon.dapil.jenis_dewan}/${$slugify(calon.dapil.nama_dapil)}/${calon.kode_dapil}/${$slugify(calon.nama)}/${calon.id}`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Hitung Suara</a>
                <a :href="$setUrl(`/surat-suara/${calon.dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : calon.dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : calon.dapil.jenis_dewan}/${$slugify(calon.dapil.nama_dapil)}/${calon.kode_dapil}/${$slugify(calon.nama)}/${calon.id}`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Lihat Surat Suara</a>
            </div>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-4">
            <ProfilDpdBlock :calon="calon"/>
            <div class="w-full min-h-max rounded-lg bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 duration-300 cursor-pointer p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 justify-items-center mb-4">
                    <div class="text-center p-1">
                        <div class="font-bold">Jenis Kelamin</div>
                        <h4 v-html="calon.jenis_kelamin"></h4>
                    </div>
                    <div class="text-center p-1">
                        <div class="font-bold">Tempat Tinggal</div>
                        <h4>{{ calon.tempat_tinggal }}</h4>
                    </div>
                    <div v-if="calon.profil_data && calon.profil_data.disabilitas" class="text-center p-1">
                        <h5 class="font-bold">Disabilitas</h5>
                        <div>{{ calon.profil_data.disabilitas }}</div>
                    </div>
                </div>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_pekerjaan && calon.profil_data.riwayat_pekerjaan.length > 1" :data_riwayat="calon.profil_data.riwayat_pekerjaan" :title="'RIWAYAT PEKERJAAN'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_pendidikan && calon.profil_data.riwayat_pendidikan.length > 1" :data_riwayat="calon.profil_data.riwayat_pendidikan" :title="'RIWAYAT PENDIDIKAN'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_organisasi && calon.profil_data.riwayat_organisasi.length > 1" :data_riwayat="calon.profil_data.riwayat_organisasi" :title="'RIWAYAT ORGANISASI'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_kursus_diklat && calon.profil_data.riwayat_kursus_diklat.length > 1" :data_riwayat="calon.profil_data.riwayat_kursus_diklat" :title="'RIWAYAT KURSUS DAN DIKLAT'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_penghargaan && calon.profil_data.riwayat_penghargaan.length > 1" :data_riwayat="calon.profil_data.riwayat_penghargaan" :title="'RIWAYAT PENGHARGAAN'"/>
                <div>
                    <p class="font-semibold">Sumber Data</p>
                    <p>
                        <a href="https://infopemilu.kpu.go.id/Pemilu/Peserta_pemilu" rel="nofollow" target="_blank" class="text-indigo-600 hover:text-indigo-900">DCT Info Pemilu KPU</a>, terakhir akses tanggal 18 Januari 2024
                    </p>
                </div>
            </div>
        </div>
        <div class="min-w-32 bg-white flex justify-center overflow-hidden m-2 mb-10">
            <img v-bind:src="$setUrl('/assets/img/sura_dan_sulu-01.webp')" alt="Sura dan Sulu" loading="lazy">
        </div>
    </div>
</template>
<script setup>
import ProfilDpdBlock from '../Components/ProfilDpdBlock.vue';
import TableRiwayatBlock from '../Components/TableRiwayatBlock.vue';

let props = defineProps({
    calon: Object,
    header_title: String
})
</script>