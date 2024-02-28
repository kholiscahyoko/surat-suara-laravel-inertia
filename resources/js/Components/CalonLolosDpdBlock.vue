<template>
    <a :href="calon.url_profil" class="w-56 hover:text-indigo-700 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 hover:-translate-y-1 hover:h-max hover:scale-105 duration-300 cursor-pointer p-4">
        <div class="items-center font-bold mb-4">
            <h3 class="text-xl text-center">
                NO URUT
                <span class="block text-2xl">{{ calon.nomor_urut }}</span>
            </h3>
        </div>
        <div class="w-full flex justify-center">
            <img ref="image" :src="$setUrl(creatorImage)" @error="imageError = true" :alt="calon.nama" class="object-cover w-40 transition ease-in-out delay-150 rounded-md shadow-lg shadow-black mb-4" loading="lazy">
        </div>
        <div class="items-center font-bold mb-4">
            <h2 class="text-xl font-bold tracking-tight text-center mb-4">
                {{ calon.nama }}
            </h2>
        </div>
        <div class="items-center font-semibold mb-4">
            <h3 class="text-xl text-center">
                {{ calon.jumlah_suara.toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2}) }} ({{ calon.persen.toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2}) }}%)
                <span class="block text-2xl">Suara</span>
            </h3>
        </div>
    </a>
</template>
<script>
export default{
    props: {
        calon: Object,
    },
    data() {
        return {
            imageError: false,
            defaultImage: `/assets/img/kpu_monochrome.webp`,
            queryParams: null,
        };
    },
    computed: {
        creatorImage() {
            return this.imageError ? this.defaultImage : `/assets/img/dpd_foto/compressed/${this.calon.foto.split('/').slice(-1).join().split('.').slice(0,-1).join().replace(/[^\p{L}\d]+/gu, '-').normalize('NFKD').replace(/[̀-ͯ]/g, '').replace(/[^-\w]+/g, '').trim().replace(/[\W_]+/g, ' ').trim().replace(/\s/g, '-').toLowerCase()}.webp`
        }
    }
};</script>