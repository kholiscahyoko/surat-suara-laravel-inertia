<template>
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="z-20 object-contain w-12 lg:w-32 lg:h-32" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold lg:text-4xl">
                    <h2 class="text-white">
                        PROFIL CALON
                        <span class="block lg:text-3xl" v-html="header_title" />
                    </h2>
                </div>
                <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg')" class="z-20 object-contain w-12 lg:w-32 lg:h-32" alt="Pemilu Sarana Integrasi Bangsa" loading="lazy">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
            <h3 class="text-center font-bold lg:text-4xl">
                DAERAH PEMILIHAN<br>
                <span class="block lg:text-3xl">{{ calon.dapil.nama_dapil }}</span>
            </h3>
            <div class="flex justify-center flex-wrap align-middle mt-2">
                <WilayahListBlock :kode_dapil="calon.dapil.kode_dapil"/>
                <a :href="$setUrl(`/surat-suara/${calon.dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : calon.dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : calon.dapil.jenis_dewan}/${$slugify(calon.dapil.nama_dapil)}/${calon.kode_dapil}/${$slugify(calon.nama)}/${calon.id}`)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 text-center focus:outline-none">Lihat Surat Suara</a>
            </div>
        </div>
        <div class="flex flex-wrap items-start justify-center mt-4">
            <ProfilDewanBlock :calon="calon"/>
            <div class="w-full px-3 text-sm">
            </div>
            <div class="w-full min-h-max rounded-lg bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 duration-300 cursor-pointer p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 justify-items-center mb-4">
                    <div v-if="calon.profil_data && calon.profil_data.tempat_lahir" class="text-center p-1">
                        <h5 class="font-bold">Tempat Lahir</h5>
                        <div class="inline-block">{{ calon.profil_data.tempat_lahir }}</div>
                    </div>
                    <div v-if="calon.profil_data && calon.profil_data.tanggal_lahir" class="text-center p-1">
                        <h5 class="font-bold">Tanggal Lahir</h5>
                        <div>{{ calon.profil_data.tanggal_lahir }}</div>
                    </div>
                    <div v-if="calon.profil_data && calon.profil_data.tanggal_lahir" class="text-center p-1">
                        <h5 class="font-bold">Usia</h5>
                        <div v-text="`${getYearDifference(parseDate(props.calon.profil_data.tanggal_lahir), new Date())} Tahun`"></div>
                    </div>
                    <div class="text-center p-1">
                        <div class="font-bold">Jenis Kelamin</div>
                        <h4 v-html="calon.jenis_kelamin"></h4>
                    </div>
                    <div class="text-center p-1">
                        <div class="font-bold">Tempat Tinggal</div>
                        <h4>{{ calon.tempat_tinggal }}</h4>
                    </div>
                    <div v-if="calon.profil_data && calon.profil_data.agama" class="text-center p-1">
                        <div class="font-bold">Agama</div>
                        <h4>{{ calon.profil_data.agama }}</h4>
                    </div>
                    <div v-if="calon.profil_data && calon.profil_data.perkawinan" class="text-center p-1">
                        <div class="font-bold">Status Perkawinan</div>
                        <h4>{{ calon.profil_data.perkawinan == 'S' ? 'Sudah' : calon.profil_data.perkawinan == 'P' ? 'Pernah' : calon.profil_data.perkawinan }}</h4>
                    </div>
                    <div v-if="calon.profil_data && calon.profil_data.disabilitas" class="text-center p-1">
                        <h5 class="font-bold">Disabilitas</h5>
                        <div>{{ calon.profil_data.disabilitas }}</div>
                    </div>
                </div>
                <div v-if="calon.profil_data && calon.profil_data.pekerjaan" class="mb-2">
                    <h5 class="font-bold lg:text-lg mb-1">PEKERJAAN</h5>
                    <div class="px-4">
                        <p>{{ calon.profil_data.pekerjaan }}</p>
                    </div>
                </div>
                <div v-if="calon.profil_data && calon.profil_data.hukum" class="mb-2">
                    <h5 class="font-bold lg:text-lg mb-1">STATUS HUKUM</h5>
                    <div class="px-4">
                        <p>{{ calon.profil_data.hukum }}</p>
                    </div>
                </div>
                <div v-if="calon.profil_data && calon.profil_data.alamat" class="mb-4">
                    <h5 class="font-bold lg:text-lg mb-1">ALAMAT</h5>
                    <div class="border border-solid border-black px-4 py-2">
                        <ul>
                            <li v-for="alamat in calon.profil_data.alamat">
                                {{ alamat }}
                            </li>
                        </ul>
                    </div>
                </div>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_pendidikan && calon.profil_data.riwayat_pendidikan.length > 1" :data_riwayat="calon.profil_data.riwayat_pendidikan" :title="'RIWAYAT PENDIDIKAN'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_pekerjaan && calon.profil_data.riwayat_pekerjaan.length > 1" :data_riwayat="calon.profil_data.riwayat_pekerjaan" :title="'RIWAYAT PEKERJAAN'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_organisasi && calon.profil_data.riwayat_organisasi.length > 1" :data_riwayat="calon.profil_data.riwayat_organisasi" :title="'RIWAYAT ORGANISASI'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_kursus_diklat && calon.profil_data.riwayat_kursus_diklat.length > 1" :data_riwayat="calon.profil_data.riwayat_kursus_diklat" :title="'RIWAYAT KURSUS DAN DIKLAT'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_penghargaan && calon.profil_data.riwayat_penghargaan.length > 1" :data_riwayat="calon.profil_data.riwayat_penghargaan" :title="'RIWAYAT PENGHARGAAN'"/>
                <TableRiwayatBlock v-if="calon.profil_data && calon.profil_data.riwayat_pasangan && calon.profil_data.riwayat_pasangan.length > 1" :data_riwayat="calon.profil_data.riwayat_pasangan" :title="'RIWAYAT PASANGAN'"/>
                <div>
                    <p class="font-semibold">Sumber Data</p>
                    <p>
                        <a href="https://infopemilu.kpu.go.id/Pemilu/Peserta_pemilu" class="text-indigo-600 hover:text-indigo-900">DCT Info Pemilu KPU</a>, terakhir akses tanggal 18 Januari 2024
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
import ProfilDewanBlock from '../Components/ProfilDewanBlock.vue';
import TableRiwayatBlock from '../Components/TableRiwayatBlock.vue';
import WilayahListBlock from '../Components/WilayahListBlock.vue';

let props = defineProps({
    calon: Object,
    header_title: String,
})

let parseDate = function (dateString) {
  const parts = dateString.split('-');
  
  // Ensure that the parts array has exactly three elements (day, month, year)
  if (parts.length === 3) {
    const day = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10) - 1; // Months are zero-based in JavaScript
    const year = parseInt(parts[2], 10);

    // Validate the parsed components
    if (!isNaN(day) && !isNaN(month) && !isNaN(year)) {
      return new Date(year, month, day);
    }
  }

  // Return null if the parsing fails
  return null;
}

let getYearDifference = function (startDate, endDate) {
  const startYear = startDate.getFullYear();
  const endYear = endDate.getFullYear();

  return endYear - startYear;
}

if(props.calon.profil_data && props.calon.profil_data.tanggal_lahir){
    console.log(getYearDifference(parseDate(props.calon.profil_data.tanggal_lahir), new Date()))
}

</script>