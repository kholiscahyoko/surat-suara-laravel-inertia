<template>
    <div class="w-80 md:w-56 lg:w-80 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
        <div class="text-center px-4 py-4 font-bold text-6xl">
            {{ calon.no }}
        </div>
        <div>
            <img ref="image" :src="$setUrl(`/assets/img/pilpres/${calon.no}.webp`)" :alt="calon.capres + ' - ' + calon.cawapres" class="h-auto object-cover w-full" loading="lazy">
        </div>
        <div class="text-xs flex justify-between my-4 text-center">
            <div class="w-1/2">
                <h4 class="text-gray-600">CALON PRESIDEN</h4>
                <h5 class="font-bold text-black">{{ calon.capres }}</h5>
            </div>
            <div class="w-1/2">
                <h4 class="text-gray-600">CALON WAKIL PRESIDEN</h4>
                <h5 class="font-bold text-black">{{ calon.cawapres }}</h5>
            </div>
        </div>
        <div class="min-h-24 text-xs">
            <h4 class="text-black font-bold text-center">
                GABUNGAN PARTAI POLITIK PENGUSUL
            </h4>
            <div class="flex justify-center mt-2">
                <img v-for="no_partai in calon.partai " :src="$setUrl(`/assets/img/partai/${no_partai}.webp`)" class="w-9 md:w-7 lg:w-9 object-contain mx-[1px] lg:mx-1" loading="lazy">
            </div>
            <div class="flex justify-center mt-2 mb-4">
                <a :href="calon.pdf" class="font-semibold p-2 bg-blue-600 text-white rounded-md" target="_blank">BACA VISI DAN MISI</a>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props: {
        calon : Object,
    },
};
</script>