<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Cari Surat Suara Berdasarkan Wilayah
    </h1>
    <div class="mt-4">
        <input v-model="search" type="text" placeholder="Cari" class="border px-2 rounded-lg text-lg h-12 min-w-full">
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
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <Link :href="$setUrl(`/surat-suara/${ wilayah.id_desa !== null ? 'desa' : ( wilayah.id_kecamatan !== null ? 'kecamatan' : (wilayah.id_kabkota !== null ? 'kabkota' : 'provinsi' )) }/${$slugify(wilayah.nama_desa ?? wilayah.nama_kecamatan ?? wilayah.nama_kabkota ?? wilayah.nama_provinsi)}/${wilayah.kode_wilayah}`)" class="text-indigo-600 hover:text-indigo-900">Lihat Surat Suara</Link>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="px-5 lg:px-6 py-4 text-gray-700">
                                        Nama wilayah tidak ditemukan.<br>
                                        Saran : coba gunakan nama DESA/KELURAHAN saja atau tingkatan diatasnya (KECAMATAN atau KABUPATEN/KOTA).<br>
                                        Contoh : CIDENG , jika tidak ada coba GAMBIR, jika tidak ada coba JAKARTA PUSAT<br>
                                        Jika masih tidak menemukan, coba alternatif pencarian <Link :href="$setUrl(`/calon`)" class="text-indigo-600 hover:text-indigo-900 font-semibold">Nama Calon</Link> atau <Link :href="$setUrl(`/dapil`)" class="text-indigo-600 hover:text-indigo-900 font-semibold">Nama Dapil</Link>
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
    <KawalPemilu />
</template>

<script setup>
import Pagination from '../Shared/Pagination.vue';
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3';
import KawalPemilu from '../Shared/KawalPemilu.vue';

let props = defineProps({
    wilayahs: Object,
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
    if(value.length >= 4 && value.charAt(value.length - 1) !== ' '){
        debounce(function(){
            router.get('/wilayah', { search : value }, {
                preserveState : true,
                replace: true
            });
        }, 1000); // 1000 milliseconds = 1 second
    }else{
        console.log("MINIMAL 4 KARAKTER");
    }
})
</script>