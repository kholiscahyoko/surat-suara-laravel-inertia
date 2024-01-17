<template>
    <div class="w-32 min-h-[380px] bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border border-2 border-slate-950 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
        <div class="text-center px-4 py-4 font-bold text-4xl">
            {{ calon.no_urut }}
        </div>
        <div>
            <img ref="image" :src="creatorImage" @error="imageError = true" :alt="calon.nama" class="h-48 object-cover w-full">
        </div>
        <div class="text-center px-4 py-4 min-h-24 text-sm text-wrap break-words">
            {{ calon.nama }}
        </div>
    </div>
</template>
<script>
// sample url foto anggota dpd
// https://infopemilu.kpu.go.id/berkas-dpd-dct/36/36_3_ADE YULIASIH.jpg

// import { compressImage, convertToWebP } from 'image-conversion';

export default{
    props: {
        calon : Object,
    },
    data(){
        return {
            imageError: false,
            defaultImage: `/assets/img/kpu_monochrome.webp`
        }
    },
    computed:{
        creatorImage(){
            return this.imageError ? this.defaultImage : `/assets/img/dpd_foto/compressed/${this.calon.foto.split('/').slice(-1).join().split('.').slice(0,-1).join().replace(/[^\p{L}\d]+/gu, '-').normalize('NFKD').replace(/[\u0300-\u036F]/g, '').replace(/[^-\w]+/g, '').trim().replace(/-+/g, '-').toLowerCase()}.webp`
        }
    }
};
</script>