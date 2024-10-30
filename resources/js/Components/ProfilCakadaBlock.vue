<template>
    <div class="w-80 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 duration-300 cursor-pointer p-4">
        <div class="items-center font-bold mb-4">
            <h3 class="text-xl flex items-center justify-center">
                <span class="inline-block p-2">NO URUT</span>
                <span class="inline-block text-4xl" v-html="calon.paslon ? calon.paslon.no_urut : calon.wakil_paslon.no_urut"></span>
            </h3>
        </div>
        <div class="w-full flex justify-center">
            <img
                :src="calon.image_url"
                class="object-cover w-40 transition ease-in-out delay-150 hover:-translate-y-1 hover:h-max rounded-md hover:scale-105 duration-300 shadow-lg shadow-black mb-4" loading="lazy"
                :alt="calon.nama" 
                />
        </div>
        <div class="items-center text-center mb-4">
            <h1 class="text-xl font-bold md:text-2xl lg:text-3xl font-bold tracking-tight text-gray-900 mb-2">
                {{ calon.nama }}
            </h1>
            Berpasangan dengan
            <a :href="calon.pasangan.url" class="block hover:underline text-indigo-600 font-semibold">{{ calon.pasangan.alias }}</a>
        </div>
    </div>
</template>
<script>
export default{
    props: {
        calon: Object,
    }

};</script>