<template>
    <Head>
        <title>Wilayah</title>
        <meta name="description" content="Wilayah Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Wilayah
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
                                <tr v-for="wilayah in wilayahs.data" :key="wilayah.kode_wilayah">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900" >
                                                    {{ [wilayah.nama_desa, wilayah.nama_kecamatan, wilayah.nama_kabkota, wilayah.nama_provinsi].filter(Boolean).join(', ') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="`/surat-suara/${ wilayah.id_desa !== null ? 'desa' : ( wilayah.id_kecamatan !== null ? 'kecamatan' : (wilayah.id_kabkota !== null ? 'kabkota' : 'provinsi' )) }/${wilayah.kode_wilayah}`" class="text-indigo-600 hover:text-indigo-900">Lihat Surat Suara</Link>
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
</template>

<script setup>
import Pagination from '../Shared/Pagination.vue';
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3';

let props = defineProps({
    wilayahs: Object,
    filters: Object
})

let search = ref(props.filters.search);

watch(search, value => {
    router.get('/wilayah', { search : value }, {
        preserveState : true,
        replace: true
    });
})
</script>