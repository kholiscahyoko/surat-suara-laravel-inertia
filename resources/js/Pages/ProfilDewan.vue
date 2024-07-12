<template>
    <ProfilDewan :calon="calon" :header_title="header_title" />
</template>

<script setup>
import CryptoJS from 'crypto-js'
import axios from 'axios';
import { onMounted, onUnmounted } from 'vue';
import ProfilDewan from '../Shared/ProfilDewan.vue';

let props = defineProps({
    calon: Object,
    header_title: String,
})

let configs_bg = {
    dpr : 'from-yellow-400',
    dprdp : 'from-blue-600',
    dprdk : 'from-green-600',
}

onMounted(() => {
    document.body.classList.add('bg-gradient-to-tl', configs_bg[props.calon.dapil.jenis_dewan], 'to-white');

    let url = `http://127.0.0.1:8000/data/${props.calon.dapil.jenis_dewan}/dct/${props.calon.kode_dapil}/${CryptoJS.MD5((props.calon.dapil.jenis_dewan=='dpd'? '../':'')+props.calon.foto)}.json`
    axios.get(url)
     .then(response => {
        if(response.status == 200){
            props.calon.profil_data = response.data;
        }
     console.log(response.data);
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
})

onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', configs_bg[props.calon.dapil.jenis_dewan], 'to-white');
})

</script>