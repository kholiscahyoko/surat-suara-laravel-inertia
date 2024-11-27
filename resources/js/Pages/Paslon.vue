<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Cari Nama Calon Kepala Daerah
    </h1>
    <form class="mt-4 flex space-x-2" action="/pilkada/calon">
        <input name="search" type="text" placeholder="Cari" class="border px-2 rounded-lg text-lg h-12 w-full" :value="search">
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
                                <tr v-if="paslons.data.length > 0" v-for="paslon in paslons.data" :key="paslon.id">
                                    <td class="px-1 lg:px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ paslon.nama }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center">
                                            <div v-if="paslon.wilayah.kode_wilayah.length === 2" class="text-sm font-medium rounded-lg bg-red-900 px-3 py-1 text-white text-wrap text-center">{{ paslon.wilayah.title_kada }}</div>
                                            <div v-else-if="paslon.wilayah.title_kada === 'BUPATI'" class="text-sm font-medium text-gray-900 rounded-lg bg-cyan-300 px-3 py-1 text-wrap text-center">{{ paslon.wilayah.title_kada }}</div>
                                            <div v-else class="text-sm font-medium text-white rounded-lg bg-cyan-600 px-3 py-1 text-wrap text-center">{{ paslon.wilayah.title_kada }}</div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center">
                                            <div class="text-sm font-medium p-1 text-wrap text-center">
                                                {{ paslon.wilayah.title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 lg:px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex flex-wrap items-center">
                                            <a :href="paslon.url" class="text-white hover:bg-teal-900 p-1 bg-teal-600 rounded-md block m-1 text-center">Visi Misi</a>
                                            <a :href="paslon.calon.url" class="text-white hover:bg-teal-900 p-1 bg-teal-600 rounded-md block m-1 text-center">Profil Calon</a>
                                            <a :href="paslon.wakil_calon.url" class="text-white hover:bg-teal-900 p-1 bg-teal-600 rounded-md block m-1 text-center">Profil Wakil</a>
                                            <a :href="paslon.wilayah.url" class="text-white hover:bg-teal-900 p-1 bg-teal-600 rounded-md block m-1 text-center">Surat Suara</a>
                                            <a :href="paslon.wilayah.realcount_url" class="text-white hover:bg-teal-900 p-1 bg-teal-600 rounded-md block m-1 text-center">Real Count</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="px-5 lg:px-6 py-4 text-gray-600">
                                        Nama tidak ditemukan.<br>
                                        Coba alternatif pencarian <a :href="$setUrl(`/cari`)" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-semibold">Disini</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <Pagination :data="paslons" />
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
    paslons: Object,
    filters: Object
})

let search = ref(props.filters.search);

var processing = ref(false);

//simulate form submission
const submitSearch = function(value){
    router.get('/pilkada/paslon', { search : value }, {
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