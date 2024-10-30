<template>
    <div class="w-80 lg:w-96 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 transition ease-in-out delay-150 hover:-translate-y-1">
        <div class="text-center px-4 py-4 font-bold text-6xl">
            {{ paslon.no_urut }}
        </div>
        <div class="flex justify-between my-4 text-center">
            <a :href="paslon.calon.url" class="w-1/2 hover:scale-110 duration-300">
                <img ref="image" :src="paslon.calon.image_url" :alt="paslon.calon.nama" class="h-auto object-cover w-full" loading="lazy">
            </a>
            <a :href="paslon.wakil_calon.url" class="w-1/2 hover:scale-110 duration-300">
                <img ref="image" :src="paslon.wakil_calon.image_url" :alt="paslon.wakil_calon.nama" class="h-auto object-cover w-full" loading="lazy">
            </a>
        </div>
        <div class="text-xs flex justify-between my-4 text-center">
            <div class="w-1/2">
                <h4 class="text-gray-600">CALON {{ paslon.calon.type }}</h4>
                <a :href="paslon.calon.url" class="text-indigo-600">
                    <h5 class="font-bold">{{ paslon.calon.nama }}</h5>
                </a>
            </div>
            <div class="w-1/2">
                <h4 class="text-gray-600">CALON {{ paslon.wakil_calon.type }}</h4>
                <a :href="paslon.wakil_calon.url" class="text-indigo-600">
                    <h5 class="font-bold">{{ paslon.wakil_calon.nama }}</h5>
                </a>
            </div>
        </div>
        <div class="min-h-24 text-xs pb-4">
            <h4 class="text-black font-bold text-center">
                {{ paslon.partais.length > 0 ? 'GABUNGAN PARTAI POLITIK': 'CALON INDEPENDEN' }}
            </h4>
            <div class="flex justify-center mt-2">
                <img v-for="partai in paslon.partais " :src="$setUrl(`/assets/img/partai/${partai.no_urut}.webp`)" :style="{ width: `${90 / paslon.partais.length}%` }" class="max-w-9 md:max-w-7 lg:max-w-9 object-contain mx-[1px]" :alt="partai.nama" loading="lazy">
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props: {
        paslon : Object,
    },
};
</script>