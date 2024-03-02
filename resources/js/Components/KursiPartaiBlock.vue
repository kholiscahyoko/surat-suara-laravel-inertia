<template>
    <div class="w-64 min-h-max bg-white overflow-hidden shadow-xl shadow-slate-600 mb-10 border-2 border-slate-950 duration-300 cursor-pointer p-4 mx-2">
        <div class="items-center font-bold mb-4">
            <h3 class="text-xl flex items-center justify-center">
                <span class="inline-block p-2">NO URUT</span>
                <span class="inline-block text-4xl">{{ partai?.nomor_urut }}</span>
            </h3>
        </div>
        <div class="w-full flex justify-center mb-4">
            <img v-bind:src="$setUrl(`/assets/img/partai/${partai.nomor_urut}.webp`)" class="w-32 h-32 mx-2 object-contain" :alt="partai.nama" loading="lazy">
        </div>
        <div class="items-center font-bold mb-4">
            <h2 class="text-2xl font-bold tracking-tight text-center text-gray-900 mb-4">
                {{ partai.nama }}
            </h2>
        </div>
        <div class="items-center font-semibold mb-4">
            <h3 class="text-2xl text-center">
                {{ data.jml_suara_total.toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2}) }}
                <span class="block text-xl">Suara</span>
            </h3>
        </div>
        <div class="items-center font-semibold mb-4">
            <h3 class="text-4xl font-bold tracking-tight text-center text-gray-900 mb-4 flex items-center justify-center">
                {{ data.list.length }}&nbsp;<span class="text-xl">KURSI</span>
            </h3>
        </div>
    </div>
</template>
<script setup>
let props = defineProps({
        data: Object,
        partai: Object,
    })

let cek = function(partai_no){
    console.log(partai_no);
    console.log(this.props.data);
    console.log(this.props.data[partai_no]);
}
</script>