<template>
    <div>
        <div>
            <button id="button" data-modal-toggle="modal" data-modal-target="modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none" @click="get_list_wilayah()">Lihat Lingkup Wilayah</button>
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
    </div>
</template>
<script setup>
import { onMounted, ref, inject } from 'vue';
import axios from 'axios';
import { initModals } from 'flowbite';

let props = defineProps({
    'kode_dapil' : String
})

const wilayah_list = ref(null);
const setUrl = inject('$setUrl');

let get_list_wilayah = function(){
    if(wilayah_list.value == null){
        let url = setUrl(`/get_list_wilayah_by_dapil?kode_dapil=${props.kode_dapil}`);
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
    }
    ;
}

onMounted(() => {
    initModals();
})


</script>