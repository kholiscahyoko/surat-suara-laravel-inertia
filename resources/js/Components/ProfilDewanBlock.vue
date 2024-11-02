<template>
    <div class="w-80 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 duration-300 cursor-pointer p-4">
        <div class="flex items-center px-4 py-4 border-b border-black">
            <div class="font-bold w-10 text-4xl text-center">{{ calon.partai.no_urut }}</div>
            <img v-bind:src="$setUrl(`/assets/img/partai/${calon.partai.no_urut}.webp`)" class="w-20 h-20 mx-2 object-contain" :alt="calon.partai.nama" loading="lazy">
            <div class="font-semibold text-wrap text-lg lg:text-xl">{{ calon.partai.nama }}</div>
        </div>
        <div class="items-center font-bold mb-4">
            <h3 class="text-xl flex items-center justify-center">
                <span class="inline-block p-2">NO URUT</span>
                <span class="inline-block text-4xl">{{ calon.no_urut }}</span>
            </h3>
        </div>
        <div class="w-full flex justify-center" :style="`background-image`">
            <div class="relative w-40 h-52 flex items-center justify-center overflow-hidden transition ease-in-out delay-150 hover:-translate-y-1 rounded-md hover:scale-105 duration-300 shadow-lg shadow-black mb-4 bg-cover bg-center" :style="{ backgroundImage: isImageLoaded ? 'none' : `url('`+$setUrl(`/assets/img/kpu_monochrome.webp`)+`')`}">
                <img :src="imageSrc" class="max-w-full object-contain" loading="lazy" :alt="calon.nama" @load="handleImageLoad" onerror="this.style.display='none';"/>
            </div>
        </div>
        <div class="items-center font-bold mb-4">
            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold tracking-tight text-center text-gray-900 mb-4">
                {{ calon.nama }}
            </h1>
        </div>
    </div>
</template>
<script>
export default{
    props: {
        calon: Object,
    },
    data() {
        return {
            isImageLoaded : false,
            imageSrc: this.calon.foto,
        };
    },
    methods:{
        handleImageLoad() {
            this.isImageLoaded  = true;
        },
        onImageError() {
            this.isImageLoaded = false;
        },
    }
};</script>