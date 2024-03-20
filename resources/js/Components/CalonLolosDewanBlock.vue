<template>
    <a :href="calon.url_profil" class="w-52 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 transition ease-in-out delay-150 hover:-translate-y-1 hover:h-max hover:scale-105 duration-300 cursor-pointer p-1 hover:text-indigo-800 mx-2" :class="`partai-no-${partai.nomor_urut}`">
        <div class="flex justify-center px-4 py-2 border-b border-black text-center">
            <div class="font-semibold text-wrap text-sm lg:text-lg">{{ partai.nama }}</div>
        </div>
        <div class="items-center font-bold mb-2">
            <h3 class="text-lg flex items-center justify-center">
                <span class="inline-block p-2">NO URUT</span>
                <span class="inline-block text-xl">{{ calon.nomor_urut }}</span>
            </h3>
        </div>
        <div class="w-full flex justify-center">
            <img
                v-if="loaded"
                :src="imageSrc"
                @load="handleImageLoad"
                class="object-cover w-32 rounded-md shadow-lg shadow-black mb-4" loading="lazy"
                :alt="calon?.nama" 
                />
            <img v-else :src="$setUrl(`/assets/img/kpu_monochrome.webp`)" class="object-cover w-40 transition ease-in-out delay-150 hover:-translate-y-1 hover:h-max rounded-md hover:scale-105 duration-300 shadow-lg shadow-black mb-4" loading="lazy" :alt="calon?.nama" />
        </div>
        <div class="items-center font-semibold mb-4 px-2">
            <h2 class="text-sm md:text-base lg:text-lg font-semibold tracking-tight text-center mb-4">
                {{ calon?.nama }}
            </h2>
        </div>
        <div class="items-center font-semibold mb-4">
            <h3 class="text-xl text-center">
                {{ calon?.jumlah_suara.toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2}) }}
                <span class="block text-2xl">Suara</span>
            </h3>
        </div>
    </a>
</template>
<script>
export default{
    props: {
        calon: Object,
        partai: Object,
    },
    data() {
        return {
            loaded: false,
            imageSrc: this.calon?.foto,
        };
    },
    methods:{
        handleImageLoad() {
            this.loaded = true;
        },
    },
    mounted() {
        const actualImage = new Image();
        actualImage.src = this.imageSrc;

        actualImage.onload = () => {
            // Actual image has loaded, switch to it
            this.loaded = true;
        };

        actualImage.onerror = () => {
            // Handle error if the image fails to load
            console.error('Error loading actual image');
        };
    },

};</script>