<template>
    <Link class="w-64 bg-white rounded-lg overflow-hidden mx-10 shadow-xl shadow-slate-600 mr-4 mb-10 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300" :href="$setUrl(`/surat-suara/${jenis}/${surat_suara ? surat_suara.kode_dapil : ''}`)">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="object-contain w-10 h-11" alt="">
                <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_2024.webp')" class="object-contain w-10 h-14" alt="">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
        </div>
        <div class="pt-8 min-h-44">
            <h2 class="text-center text-2xl font-bold whitespace-normal">
                SURAT SUARA
                <span class="block text-sm">
                    {{ configs[jenis].label }}
                </span>
            </h2>
        </div>
        <div class="min-h-14" :class="configs[jenis].color"></div>
    </Link>
</template>
<script setup>
defineProps({
    surat_suara : Object,
    jenis : String
})

let configs = {
    'pilpres' : {
        label : 'PRESIDEN DAN WAKIL PRESIDEN', color : 'bg-gray-600' 
    },
    'dpd' : {
        label : 'DEWAN PERWAKILAN DAERAH REPUBLIK INDONESIA', color : 'bg-red-600' 
    },
    'dpr' : {
        label : 'DEWAN PERWAKILAN RAKYAT REPUBLIK INDONESIA', color : 'bg-yellow-500' 
    },
    'dprdp' : {
        label : 'DEWAN PERWAKILAN RAKYAT DAERAH PROVINSI', color : 'bg-blue-600' 
    },
    'dprdk' : {
        label : 'DEWAN PERWAKILAN RAKYAT DAERAH KABUPATEN/KOTA', color : 'bg-green-600' 
    },
}
</script>