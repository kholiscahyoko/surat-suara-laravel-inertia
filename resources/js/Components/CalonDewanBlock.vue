<template>
    <div :id="`partai${partai.no_urut}`" class="block-dewan w-64 lg:min-h-[440px] bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border border-2 border-slate-950  transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
        <div class="flex items-center px-4 py-4 border-b border-black">
            <div class="font-bold w-10 h-5 text-3xl text-center">{{ partai.no_urut }}</div>
            <img v-bind:src="`/assets/img/partai/${partai.no_urut}.webp`" class="w-20 h-20 mx-2 object-contain" alt="">
            <div class="font-semibold text-wrap text-sm">{{ partai.nama }}</div>
        </div>
        <table class="min-w-full">
            <tbody class="divide-y divide-dashed divide-gray-600">
                <tr v-for="calon in partai.calons" :class="checkId(calon.id, partai.no_urut) ? 'bg-yellow-300' : ''">
                    <td class="p-2 w-1/12">{{ calon.no_urut }}.</td>
                    <td class="p-2 text-sm">{{ calon.nama }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    partai: Object
});

const queryParams = new URLSearchParams(window.location.search);
const calon_id = queryParams.get('calon_id');
let checkId = function(calonId, partaiNoUrut) {
    if(calon_id == calonId){
        window.location.replace( `#partai${partaiNoUrut}`);
        return true;
    }else{
        return false;
    }
}    
</script>