<template>
    <a class="w-72 bg-white rounded-lg overflow-hidden mx-10 shadow-xl shadow-slate-600 mr-4 mb-10 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300" :href="wilayah.realcount_url">
        <div>
            <div class="flex items-center justify-between pt-5 px-5 min-h-20 space-x-4">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="object-contain w-10 h-11" alt="Komisi Pemilihan Umum" loading="lazy">
                <div class="block text-center font-bold lg:text-lg">
                </div>
                <img :src="wilayah.image_url" class="object-contain w-10 h-14" :alt="wilayah.title" loading="lazy">
            </div>
        </div>
        <div class="flex justify-center min-h-14 items-center align-middle text-center font-bold ">
            <h3>
                HITUNG SUARA
            </h3>
        </div>
        <div class="min-h-44 flex justify-center mt-4">
            <h2 class="text-center whitespace-normal">
                PEMILIHAN<br>
                {{ wilayah.title_kada }} DAN WAKIL {{ wilayah.title_kada }}<br>
                {{ wilayah.title }}<br>
                TAHUN 2024
            </h2>
        </div>
        <div class="text-center text-xs py-2">
            KOMISI PEMILIHAN UMUM
        </div>
    </a>
</template>
<script setup>
defineProps({
    wilayah : Object
})

let configs = {
    'GUBERNUR' : {
        footer : { class: "bg-red-900 text-xs text-white" }
    },
    'WALIKOTA' : {
        footer : { class: "bg-cyan-600 text-xs text-white" }
    },
    'BUPATI' : {
        footer : { class: "bg-cyan-300 text-xs text-black" }
    },
}
</script>