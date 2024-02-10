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
                                    <td class="px-1 lg:px-6 py-4 text-right text-sm font-medium flex justify-end">
                                        <button :id="`button-${dapil.kode_dapil}`" data-modal-toggle="modal" data-modal-target="modal" type="button" class="text-white hover:bg-teal-900 p-1 bg-teal-600 rounded-md block m-1 text-center" @click="get_list_wilayah(dapil.kode_dapil)">Lingkup Wilayah</button>
                                        <Link :href="$setUrl(`/surat-suara/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama)}/${dapil.kode_dapil}`)" class="text-white hover:bg-indigo-900 p-1 bg-indigo-600 rounded-md block m-1 text-center">Surat Suara</Link>
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
    <div id="modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                        Lingkup Wilayah
                    </h3>
                    <button id="closeButton" data-modal-hide="modal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <!-- Modal body -->
                <div v-for="(wilayahs, tingkatan) in wilayah_list" :key="tingkatan">
                    <div class="px-6 py-2 space-y-1">
                        <h4 class="font-bold">
                            {{ tingkatan }}
                        </h4>
                        <div class="flex flex-wrap">
                            <div class="bg-blue-500 text-white p-1 rounded-lg text-sm mr-1 mb-1 transition ease-in-out hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer" v-for="nama_wilayah in wilayahs">{{ nama_wilayah }}</div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button type="button" data-modal-hide="modal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Pagination from '../Shared/Pagination.vue';
import {  onMounted, onUnmounted, ref, inject, watch } from "vue";
import { router } from '@inertiajs/vue3';
import { initModals } from 'flowbite';
import axios from 'axios';

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

const wilayah_list = ref(null);
const setUrl = inject('$setUrl');

let get_list_wilayah = function(kode_dapil){
    let url = setUrl(`/get_list_wilayah_by_dapil?kode_dapil=${kode_dapil}`);
    axios.get(url)
        .then(response => {
        if(response.status == 200){
            wilayah_list.value = response.data[0];
        }
        })
        .catch(function (error) {
        if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
        } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.log(error.request);
        } else {
            // Something happened in setting up the request that triggered an Error
            console.log('Error', error.message);
        }
        console.log(error.config);
    })
    ;
}

onMounted(() => {
    initModals();
})

onUnmounted(() => {
    document.querySelector("body > div[modal-backdrop]")?.remove();
    document.querySelector("body").classList.remove("overflow-hidden");
})

</script>