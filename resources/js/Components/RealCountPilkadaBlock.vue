<template>
    <a :href="paslon.url" :class="jumlah_paslon == 4 ? 'w-80 md:w-40 lg:w-52 xl:w-64' : 'w-80 md:w-52 lg:w-96'" class="min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-gray-500 transition ease-in-out delay-150 hover:scale-105 duration-300 hover:-translate-y-1 rounded-lg">
        <div v-if="paslon.nama !== ''" class="flex justify-between border-b-2 border-gray-500" :style="`background-color:${paslon.warna}`">
            <div class="w-1/3 border-r-2 border-gray-500">
                <div class="flex justify-between text-center">
                    <div class="w-1/2">
                        <img ref="image" :src="paslon.calon.image_url" :alt="paslon.calon.nama" class="h-auto object-cover w-full" loading="lazy">
                    </div>
                    <div class="w-1/2">
                        <img ref="image" :src="paslon.wakil_calon.image_url" :alt="paslon.wakil_calon.nama" class="h-auto object-cover w-full" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center text-center">
                <div class="text-4xl font-bold align-middle px-5" v-html="`${((paslon.suara/total_suara)*100).toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2})}<span class='font-semibold'>%</span>`"></div>
                <div class="text-sm font-semibold" v-html="`${(paslon.suara).toLocaleString('en-US', { style: 'decimal'})} Suara`"></div>
            </div>
        </div>
        <div v-else class="flex justify-between my-4 text-center min-h-96 w-full">
        </div>
        <div class="inline-flex min-h-16">
            <div class="flex flex-col justify-center text-center w-[60px]" :style="`background-color:${paslon.warna}`">
                <h4 class="text-3xl font-bold align-middle">{{ paslon.no_urut }}</h4>
            </div>
            <div class="flex flex-col justify-center px-2">
                <h4 class="font-semibold text-xl align-middle">{{ paslon.nama }}</h4>
            </div>
        </div>
    </a>
</template>
<script>
export default{
    props: {
        paslon : Object,
        jumlah_paslon : Number,
        total_suara : Number,
    },
};
</script>