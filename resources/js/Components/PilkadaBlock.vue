<template>
    <a :href="paslon.url" :class="jumlah_paslon == 4 ? 'w-80 md:w-40 lg:w-52 xl:w-64' : 'w-80 md:w-52 lg:w-96'" class="min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 transition ease-in-out delay-150 hover:scale-105 duration-300 hover:-translate-y-1">
        <div class="text-center px-4 py-4 font-bold text-5xl">
            {{ paslon.no_urut }}
        </div>
        <div v-if="paslon.nama !== ''">
            <div class="flex justify-between my-4 text-center">
                <div class="w-1/2">
                    <img ref="image" :src="paslon.calon.image_url" :alt="paslon.calon.nama" class="h-auto object-cover w-full" loading="lazy">
                </div>
                <div class="w-1/2">
                    <img ref="image" :src="paslon.wakil_calon.image_url" :alt="paslon.wakil_calon.nama" class="h-auto object-cover w-full" loading="lazy">
                </div>
            </div>
            <div class="text-xs flex justify-between my-4 text-center">
                <div class="w-1/2">
                    <h4 class="text-gray-600">CALON {{ paslon.calon.type }}</h4>
                    <div class="text-indigo-600">
                        <h5 class="font-bold break-words">{{ paslon.calon.nama }}</h5>
                    </div>
                </div>
                <div class="w-1/2">
                    <h4 class="text-gray-600">CALON {{ paslon.wakil_calon.type }}</h4>
                    <div class="text-indigo-600">
                        <h5 class="font-bold break-words">{{ paslon.wakil_calon.nama }}</h5>
                    </div>
                </div>
            </div>
            <div class="min-h-24 text-xs pb-4">
                <h4 class="text-black font-bold text-center">
                    {{ paslon.partais.length > 0 ? 'GABUNGAN PARTAI POLITIK': 'CALON INDEPENDEN' }}
                </h4>
                <div class="flex justify-center mt-2">
                    <img v-for="partai in paslon.partais " :src="$setUrl(`/assets/img/partai/${partai.no_urut}.webp`)" :style="{ width: `${90 / paslon.partais.length}%` }" class="max-w-9 md:max-w-7 lg:max-w-9 object-contain mx-[1px]" :alt="partai.nama" loading="lazy">
                </div>
                <div class="flex justify-center mt-2">
                    <a :href="paslon.url" class="font-semibold px-3 py-1 bg-blue-600 text-white rounded-md text-xs m-3 text-center">BACA VISI MISI</a>
                </div>
            </div>
        </div>
        <div v-else class="flex justify-between my-4 text-center min-h-96 w-full">
        </div>
    </a>
</template>
<script>
export default{
    props: {
        paslon : Object,
        jumlah_paslon : Number,
    },
};
</script>