<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Cari Surat Suara Berdasarkan Wilayah
    </h1>
    <form class="mt-4 flex space-x-2" action="/wilayah">
        <input name="search" type="text" placeholder="Cari" class="border px-2 rounded-lg text-lg h-12 w-full" v-on:keyup.native.enter="handleInput" :disabled="processing">
        <button class="px-8 bg-blue-600 text-white font-semibold rounded-lg">Cari</button>
    </form>
    <div class="mt-4 w-full">
        <HorizontalAds1/>
    </div>
    <div class="mt-4">
        <!-- table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="wilayahs.data.length > 0" v-for="wilayah in wilayahs.data" :key="wilayah.kode_wilayah">
                                    <td class="px-6 py-4 ">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900" >
                                                    {{ [wilayah.nama_desa, wilayah.nama_kecamatan, wilayah.nama_kabkota, wilayah.nama_provinsi].filter(Boolean).join(', ') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4 text-right text-xs md:text-sm font-medium flex justify-end">
                                        <a :href="$setUrl(`/hitung-suara/${ wilayah.id_desa !== null ? 'desa' : ( wilayah.id_kecamatan !== null ? 'kecamatan' : (wilayah.id_kabkota !== null ? 'kabkota' : 'provinsi' )) }/${$slugify(wilayah.nama_desa ?? wilayah.nama_kecamatan ?? wilayah.nama_kabkota ?? wilayah.nama_provinsi)}/${wilayah.kode_wilayah}`)" class="text-white hover:bg-indigo-900 p-1 bg-teal-600 rounded-md block m-1 text-center">Real Count</a>
                                        <a :href="$setUrl(`/surat-suara/${ wilayah.id_desa !== null ? 'desa' : ( wilayah.id_kecamatan !== null ? 'kecamatan' : (wilayah.id_kabkota !== null ? 'kabkota' : 'provinsi' )) }/${$slugify(wilayah.nama_desa ?? wilayah.nama_kecamatan ?? wilayah.nama_kabkota ?? wilayah.nama_provinsi)}/${wilayah.kode_wilayah}`)" class="text-white hover:bg-indigo-900 p-1 bg-indigo-600 rounded-md block m-1 text-center">Surat Suara</a>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="px-5 lg:px-6 py-4 text-gray-700">
                                        Nama wilayah tidak ditemukan.<br>
                                        Saran : coba gunakan nama DESA/KELURAHAN saja atau tingkatan diatasnya (KECAMATAN atau KABUPATEN/KOTA).<br>
                                        Contoh : CIDENG , jika tidak ada coba GAMBIR, jika tidak ada coba JAKARTA PUSAT<br>
                                        Jika masih tidak menemukan, coba alternatif pencarian <a :href="$setUrl(`/cari`)" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-semibold">Disini</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <Pagination :data="wilayahs" />
        </div>
    </div>
    <Donations />
</template>

<script setup>
import Pagination from '../Shared/Pagination.vue';
import Donations from '../Components/Donations.vue';
import { ref } from "vue";
import { router } from '@inertiajs/vue3';
import HorizontalAds1 from '../Components/HorizontalAds1.vue';

let props = defineProps({
    wilayahs: Object,
    filters: Object
})

let search = ref(props.filters.search);
var processing = ref(false);

//simulate form submission
const submitSearch = function(value){
    router.get('/wilayah', { search : value }, {
        preserveState : true,
        replace: true,
        onStart: () => {
            processing.value = true;
        },
        onFinish: () => {
            processing.value = false;
        }
    });
}

// Function to handle input events
const handleInput = () => {
//   // Clear any existing timeout
//   clearTimeout(timerId);

//   // Start a new timeout
//   timerId = setTimeout(() => {
//     // Perform action when user stops typing for 1 second
//     console.log('User stopped typing');
//     // You can call your submitForm method here if needed
//     if(search.value.length >= 4 && search.value.charAt(search.value.length - 1) !== ' '){
        submitSearch(search.value); // 1000 milliseconds = 1 second
//     }else{
//         console.log("MINIMAL 4 KARAKTER");
//     }
//   }, 2000); // Timeout duration in milliseconds
};
// Initialize timerId variable
let timerId;
</script>