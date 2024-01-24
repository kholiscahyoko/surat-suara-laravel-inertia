<template>
    <div class="w-80 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border border-2 border-slate-950 duration-300 cursor-pointer p-4">
        <div class="items-center font-bold mb-4">
            <h3 class="text-xl text-center">
                NO URUT
                <span class="block text-2xl">{{ calon.no_urut }}</span>
            </h3>
        </div>
        <div class="w-full flex justify-center">
            <img ref="image" :src="$setUrl(creatorImage)" @error="imageError = true" :alt="calon.nama" class="h-auto object-cover w-40 h-40 rounded-full shadow-lg shadow-black mb-4">
        </div>
        <div class="items-center font-bold mb-4">
            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold tracking-tight text-center text-gray-900 mb-4">
                {{ calon.nama }}
            </h1>
        </div>
    </div>
</template>
<script>
import TableRiwayatBlock from './TableRiwayatBlock.vue';

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
    },
    components: { TableRiwayatBlock }
};</script>