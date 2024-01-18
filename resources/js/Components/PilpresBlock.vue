<template>
    <div class="w-80 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border border-2 border-slate-950 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
        <div class="text-center px-4 py-4 font-bold text-6xl">
            {{ calon.no }}
        </div>
        <div>
            <img ref="image" :src="$setUrl(`/assets/img/pilpres/${calon.no}.webp`)" :alt="calon.capres + ' - ' + calon.cawapres" class="h-auto object-cover w-full">
        </div>
        <div class="text-xs flex justify-between my-4 text-center">
            <div class="w-1/2">
                <div class="text-gray-600">CALON PRESIDEN</div>
                <div class="font-bold text-black">{{ calon.capres }}</div>
            </div>
            <div class="w-1/2">
                <div class="text-gray-600">CALON WAKIL PRESIDEN</div>
                <div class="font-bold text-black">{{ calon.cawapres }}</div>
            </div>
        </div>
        <div class="min-h-24 text-xs">
            <div class="text-black font-bold text-center">
                GABUNGAN PARTAI POLITIK PENGUSUL
            </div>
            <div class="flex justify-center mt-2">
                <img v-for="no_partai in calon.partai " :src="$setUrl(`/assets/img/partai/${no_partai}.webp`)" class="w-9 object-contain mx-1">
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