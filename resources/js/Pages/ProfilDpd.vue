<template>
    <ProfilDpd :calon="calon" :header_title="header_title"/>
</template>

<script setup>
import CryptoJS from 'crypto-js'
import axios from 'axios';
import { onMounted } from 'vue';
import ProfilDpd from '../Shared/ProfilDpd.vue';

let props = defineProps({
    calon: Object,
    header_title: String
})

onMounted(() => {
    let url = `http://127.0.0.1:8000/data/${props.calon.dapil.jenis_dewan}/dct/${props.calon.kode_dapil}/${CryptoJS.MD5('../'+props.calon.foto)}.json`
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


// let calon = {
//     "kode_dapil": "11", "logo": "",
//     "id_parpol": null,
//     "nomor_urut": "1",
//     "nama": "ABDUL HADI BANG JONI",
//     "kode_calon": "71eb09708b02adc766dc07181264c207606a8c8078f50aceb7029d5b9446b7eb18d655452727cdfbf7609f052a88f27734e88dec5a1708e369d99327641c298a1lT3DwrFkNhke6Wl+Mbf5pNp+Mrb23XudSsC9IUKCK0=",
//     "profil_data":
//         {
//             "disabilitas": "Tidak",
//             "motivasi": "",
//             "riwayat_pekerjaan":
//             [
//                 ["NAMA INSTANSI", "JABATAN", "TAHUN MULAI", "TAHUN SELESAI"],
//                 ["Eumpang Breuh", "Aktor", "2006", "2020"]
//             ],
//             "riwayat_pendidikan":
//             [
//                 ["JENJANG PENDIDIKAN", "NAMA INSTITUSI", "TAHUN MULAI", "TAHUN SELESAI"],
//                 ["SD/MI", "SD Blang Reuma", "1979", "1985"],
//                 ["SMP/MTS", "SMP Negeri Meurah Mulia", "1985", "1988"],
//                 ["SMA/MA", "Madrasah Aliyah Negeri Peusangan", "1990", "1993"]
//             ],
//             "riwayat_kursus_diklat":
//             [
//                 ["NAMA KURSUS", "LEMBAGA PENYELENGGARA", "TAHUN MULAI", "TAHUN SELESAI"],
//                 ["Peningkatan Seni Budaya Aceh", "Eumpang Breuh", "2006", "2007"],
//                 ["Aktor Pemeran Utama Film Aceh", "Eumpang Breuh", "2007", "2015"]
//             ],
//             "riwayat_organisasi":
//             [
//                 ["NAMA ORGANISASI", "JABATAN", "TAHUN MULAI", "TAHUN SELESAI"],
//                 ["Eumpang Breuh", "Pengurus", "2006", "2025"]
//             ],
//             "riwayat_penghargaan":
//             [
//                 ["NAMA PENGHARGAAN", "LEMBAGA PEMBERI PENGHARGAAN", "TAHUN MULAI"],
//                 ["Aktor Film Aceh", "Pemerintah Aceh", "2017"]
//             ]
//         }
//     }
</script>