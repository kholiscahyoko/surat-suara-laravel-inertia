<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Cari Surat Suara Berdasarkan Dapil
    </h1>
    <div class="mt-4">
        Mungkin yang kamu maksud wilayah ? <Link :href="$setUrl('/wilayah')" class="text-indigo-600 font-semibold hover:text-indigo-900 text-nowrap">Cek disini</Link>
    </div>
    <div class="mt-4">
        <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg text-lg h-12 min-w-full">
    </div>
    <div class="mt-4">
        <!-- table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="dapils.data.length > 0" v-for="dapil in dapils.data" :key="dapil.id">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ dapil.nama }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div v-if="dapil.jenis_dewan === 'dpd'" class="text-sm font-medium rounded-lg bg-red-600 p-1 text-white text-wrap text-center">DPD RI</div>
                                                <div v-else-if="dapil.jenis_dewan === 'dpr'" class="text-sm font-medium text-gray-900 rounded-lg bg-yellow-400 p-1 text-wrap text-center">DPR RI</div>
                                                <div v-else-if="dapil.jenis_dewan === 'dprdp'" class="text-sm font-medium rounded-lg bg-blue-600 p-1 text-white text-wrap text-center">DPRD Provinsi</div>
                                                <div v-else-if="dapil.jenis_dewan === 'dprdk'" class="text-sm font-medium rounded-lg bg-green-600 p-1 text-white text-wrap text-center">DPRD Kab/Kota</div>
                                                <div v-else class="text-sm font-medium text-gray-900 rounded-lg bg-yellow-400 p-1 text-wrap text-center">Tidak Diketahui</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <Link :href="$setUrl(`/surat-suara/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama)}/${dapil.kode_dapil}`)" class="text-indigo-600 hover:text-indigo-900">Lihat Surat Suara</Link>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="px-5 lg:px-6 py-4 text-gray-700">
                                        Nama dapil tidak ditemukan.<br>
                                        Saran : gunakan nama provinsi atau nama kabupaten/kota (tanpa kata "PROVINSI" atau "KABUPATEN/KOTA"). Jika masih tidak menemukan, coba alternatif pencarian <Link :href="$setUrl(`/wilayah`)" class="text-indigo-600 hover:text-indigo-900 font-semibold">Nama Wilayah</Link> atau <Link :href="$setUrl(`/calon`)" class="text-indigo-600 hover:text-indigo-900 font-semibold">Nama Calon</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <Pagination :data="dapils" />
        </div>

    </div>
</template>

<script setup>
import Pagination from '../Shared/Pagination.vue';
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3';

let props = defineProps({
    dapils: Object,
    filters: Object
})

let search = ref(props.filters.search);

// Debounce function to delay processing
let timeoutId;
const debounce = (func, delay) => {
  clearTimeout(timeoutId);
  timeoutId = setTimeout(func, delay);
};

watch(search, value => {
    if(value.length >= 3 && value.charAt(value.length - 1) !== ' '){
        debounce(function(){
            router.get('/dapil', { search : value }, {
                preserveState : true,
                replace: true
            });
        }, 500); // 500 milliseconds = 0.5 seconds
    }else{
        console.log("HARUS LEBIH DARI 4 KARAKTER");
    }
})
</script>