<template>
    <div :id="`partai${partai.no_urut}`" class="block-dewan w-64 md:w-52 lg:w-64 md:min-h-[440px] bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950  transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
        <div class="flex items-center px-4 py-4 border-b border-black">
            <div class="font-bold w-10 h-5 text-3xl md:text-xl lg:text-3xl text-center">{{ partai.no_urut }}</div>
            <img v-bind:src="$setUrl(`/assets/img/partai/${partai.no_urut}.webp`)" class="w-16 h-16 md:w-12 md:h-16 lg:w-20 lg:h-20 mx-2 object-contain" :alt="partai.nama" loading="lazy">
            <h4 class="font-semibold text-wrap text-sm md:text-xs lg:text-sm">{{ partai.nama }}</h4>
        </div>
        <table class="min-w-full">
            <tbody class="divide-y divide-dashed divide-gray-600">
                <tr v-for="calon in partai.calons" :class="checkId(calon.id, partai.no_urut) ? 'bg-yellow-300' : ''">
                    <Link :href="$setUrl(`/profil-calon/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}/${$slugify(calon.nama)}/${calon.id}`)">
                        <td class="p-2 w-1/12 text-base md:text-sm lg:text-base">{{ calon.no_urut }}.</td>
                        <td class="p-2"><h5 class="text-sm md:text-xs lg:text-sm">{{ calon.nama }}</h5></td>
                    </Link>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
const props = defineProps({
    partai: Object,
    calon_id: String,
    dapil: Object
});

const calon_id = props.calon_id;
let checkId = function(calonId, partaiNoUrut) {
    if(calon_id == calonId){
        window.location.replace( `#partai${partaiNoUrut}`);
        return true;
    }else{
        return false;
    }
}    
</script>