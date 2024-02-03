<template>
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
                                    <td class="px-1 lg:px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ user.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center">
                                            <div v-if="user.jenis_dewan === 'dpd'" class="text-sm font-medium rounded-lg bg-red-600 p-1 text-white text-wrap text-center">DPD RI</div>
                                            <div v-else-if="user.jenis_dewan === 'dpr'" class="text-sm font-medium text-gray-900 rounded-lg bg-yellow-400 p-1 text-wrap text-center">DPR RI</div>
                                            <div v-else-if="user.jenis_dewan === 'dprdp'" class="text-sm font-medium rounded-lg bg-blue-600 p-1 text-white text-wrap text-center">DPRD Provinsi</div>
                                            <div v-else-if="user.jenis_dewan === 'dprdk'" class="text-sm font-medium rounded-lg bg-green-600 p-1 text-white text-wrap text-center">DPRD Kab/Kota</div>
                                            <div v-else class="text-sm font-medium text-gray-900 rounded-lg bg-yellow-400 p-1 text-wrap text-center">Tidak Diketahui</div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center">
                                            <div class="text-sm font-medium p-1 text-wrap text-center">
                                                {{ partai_aliases[user.nama_partai] ? partai_aliases[user.nama_partai] : user.nama_partai }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ user.nama_dapil }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center">
                                            <Link :href="$setUrl(`/surat-suara/${user.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : user.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : user.jenis_dewan}/${$slugify(user.nama_dapil)}/${user.kode_dapil}/${$slugify(user.name)}/${user.id}`)" class="text-white hover:bg-indigo-900 p-1 bg-indigo-600 rounded-md block m-1  text-center">Surat Suara</Link>
                                            <Link :href="$setUrl(`/profil-calon/${user.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : user.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : user.jenis_dewan}/${$slugify(user.nama_dapil)}/${user.kode_dapil}/${$slugify(user.name)}/${user.id}`)" class="text-white hover:bg-teal-900 p-1 bg-teal-600 rounded-md block m-1 text-center">Profil</Link>
                                        </div>
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

let partai_aliases = {
    'PDI PERJUANGAN' : "PDIP",
    'PARTAI KEBANGKITAN NASIONAL' : "PKN",
    'PARTAI KEBANGKITAN BANGSA' : "PKB",
    'PARTAI PERSATUAN PEMBANGUNAN' : "PPP",
    'PARTAI SOLIDARITAS INDONESIA' : "PSI",
    'PARTAI DEMOKRAT' : "Demokrat",
    'PARTAI KEADILAN SEJAHTERA' : "PKS",
    'Partai NasDem' : "NasDem",
    'PARTAI HANURA' : "HANURA",
    'PARTAI UMMAT' : "UMMAT",
    'PARTAI BURUH' : "BURUH",
    'PARTAI PERINDO' : "PERINDO",
    'PARTAI AMANAT NASIONAL' : "PAN",
    'PARTAI GELORA' : "GELORA",
    'PARTAI GERINDRA' : "GERINDRA",
    'PARTAI GOLKAR' : "GOLKAR",
    'PARTAI BULAN BINTANG' : "PBB",
    'PARTAI ADIL SEJAHTERA' : "PAS",
    'PARTAI DARUL ACEH' : "PDA",
    'PARTAI SIRA' : "SIRA",
    'PARTAI NANGGROE ACEH' : "PNA",
    'PARTAI BENDERA' : "BENDERA",
    'PARTAI GARUDA' : "GARUDA",
}

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