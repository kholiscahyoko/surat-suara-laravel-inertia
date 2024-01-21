<template>
    <Head>
        <title>Cari Berdasarkan Dapil</title>
        <meta name="description" content="Dapil Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Cari Surat Suara Berdasarkan Dapil
    </h1>
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
                                <tr v-for="dapil in dapils.data" :key="dapil.id">
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
                                                <div class="text-sm font-medium text-gray-900" v-html="dapil.jenis_dewan === 'dpd' ? 'DPD RI' : (dapil.jenis_dewan === 'dpr' ? 'DPR RI' : (dapil.jenis_dewan === 'dprdp' ? 'DPRD Provinsi' : (dapil.jenis_dewan === 'dprdk' ? 'DPRD Kab/Kota' : 'Tidak Diketahui')))"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <Link :href="$setUrl(`/surat-suara/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama)}/${dapil.kode_dapil}`)" class="text-indigo-600 hover:text-indigo-900">Lihat Surat Suara</Link>
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

watch(search, value => {
    if(value.length >= 3){
        router.get('/dapil', { search : value }, {
            preserveState : true,
            replace: true
        });
    }else{
        console.log("HARUS LEBIH DARI 4 KARAKTER");
    }
})
</script>