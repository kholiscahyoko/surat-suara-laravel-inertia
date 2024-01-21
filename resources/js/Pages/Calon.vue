<template>
    <Head>
        <title>Cari Nama Calon</title>
        <meta name="description" content="Calon Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Cari Nama Calon Legislatif
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
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ user.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ user.nama_dapil }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <Link :href="$setUrl(`/surat-suara/${user.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : user.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : user.jenis_dewan}/${$slugify(user.nama_dapil)}/${user.kode_dapil}?calon_id=${user.id}`)" class="text-indigo-600 hover:text-indigo-900">Lihat Surat Suara</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <Pagination :data="users" />
        </div>

    </div>
</template>

<script setup>
import Pagination from '../Shared/Pagination.vue';
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3';

let props = defineProps({
    users: Object,
    filters: Object
})

let search = ref(props.filters.search);

watch(search, value => {
    if(value.length >= 3){
        router.get('/calon', { search : value }, {
            preserveState : true,
            replace: true
        });
    }else{
        console.log("HARUS LEBIH DARI 4 KARAKTER");
    }
})
</script>