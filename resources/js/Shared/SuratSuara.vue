<template>
    <div class="flex flex-wrap justify-center">
        <div v-for="surat_suara in new_surat_suaras" class="w-72 bg-white rounded-lg overflow-hidden mx-10 shadow-xl shadow-slate-600 mr-4 mb-10">
            <div>
                <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                    <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="object-contain w-10 h-11" alt="Komisi Pemilihan Umum">
                    <div v-if="surat_suara.header" class="block text-center font-bold lg:text-lg">
                        <h3 class="text-white">
                            SURAT SUARA
                        </h3>
                    </div>
                    <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg')" class="object-contain w-10 h-14" alt="Pemilu Sarana Integrasi Bangsa 2024">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                    <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
                </svg>
            </div>
            <div class="min-h-44 flex justify-center items-center">
                <h2 class="text-center whitespace-normal">
                    <span v-for="body in surat_suara.body" class="block" v-html="body.label" :class="body.class">
                    </span>
                </h2>
            </div>
            <div class="text-center text-xs py-2">
                KOMISI PEMILIHAN UMUM
            </div>
            <div class="flex justify-center min-h-14 items-center align-middle text-center font-bold " v-html="surat_suara.footer.label" :class="surat_suara.footer.class">
            </div>
        </div>
    </div>
</template>
<script setup>
let surat_suaras = [
    {
        jenis : 'pilpres',
        body : [
            { label : "SURAT SUARA", class: "font-bold text-2xl" },
            { label : "PEMILIHAN UMUM<br>PRESIDEN DAN WAKIL PRESIDEN<br>REPUBLIK INDONESIA<br>TAHUN 2024", class: "font-bold text-sm" },
        ],
        footer : { label : "PEMILU PRESIDEN DAN WAKIL PRESIDEN", class: "bg-gray-600 text-xs text-white" }
    },
    {
        jenis : 'dpd',
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN DAERAH<br>REPUBLIK INDONESIA<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-sm mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPD RI", class: "bg-red-600 text-white text-lg" }
    },
    {
        jenis : 'dpr',
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN RAKYAT<br>REPUBLIK INDONESIA<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-xs mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPR RI", class: "bg-yellow-500 text-black text-lg" }
    },
    {
        jenis : 'dprd-provinsi',
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN RAKYAT<br>DAERAH PROVINSI<br>[NAMA_WILAYAH]<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-sm mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPRD PROV", class: "bg-blue-600 text-white" }
    },
    {
        jenis : 'dprd-kabkota',
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN RAKYAT<br>DAERAH KABUPATEN/KOTA<br>[NAMA_WILAYAH]<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-sm mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPRD KAB/KOTA", class: "bg-green-600 text-white" }
    },
]
</script>