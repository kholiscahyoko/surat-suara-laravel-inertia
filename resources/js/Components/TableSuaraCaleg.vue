<template>
    <div v-if="master_calon != null" :id="`partai${partai.nomor_urut}`" class="block-dewan w-64 md:w-52 lg:w-64 sm:min-h-[440px] bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950  transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
        <div class="flex items-center px-4 py-4 border-b border-black">
            <div class="font-bold w-10 h-5 text-3xl md:text-xl lg:text-3xl text-center">{{ partai.nomor_urut }}</div>
            <img v-bind:src="$setUrl(`/assets/img/partai/${partai.nomor_urut}.webp`)" class="w-16 h-16 md:w-12 md:h-16 lg:w-20 lg:h-20 mx-2 object-contain" :alt="partai.nama" loading="lazy">
            <h4 class="font-semibold text-wrap text-sm md:text-xs lg:text-sm">{{ partai.nama }}</h4>
        </div>
        <table class="min-w-full">
            <thead class="divide-y divide-dashed divide-gray-600 border-b border-black">
                <tr>
                    <td class="p-2 w-1/12 text-xs lg:text-base text-center">NO</td>
                    <td class="p-2 w-1/12 text-xs lg:text-base">NAMA</td>
                    <td class="p-2 w-1/12 text-xs lg:text-base text-right">JUMLAH</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-dashed divide-gray-600">
                <tr>
                    <td class="p-2 w-1/12 text-xs lg:text-base text-center">0.</td>
                    <td class="p-2"><h5 class="text-xs lg:text-sm">SUARA PARTAI</h5></td>
                    <td class="p-2 w-1/12 text-right text-xs lg:text-base">{{ data['jml_suara_partai'].toLocaleString('en-US', { style: 'decimal', }) }}</td>
                </tr>
                <tr class="hover:text-indigo-700" v-for="calon_data, key in master_calon" :class="calon && calon.no_urut && calon_data.nomor_urut == calon.no_urut && calon_data.nama.toLowerCase() == calon.nama.toLowerCase() ? 'bg-yellow-300 font-semibold' : ''">
                    <td class="p-2 w-1/12 text-xs lg:text-base text-center"><a class="w-full block" :href="$setUrl(`/cek-profil/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}/${$slugify(calon_data.nama)}?no_partai=${partai.nomor_urut}&no_calon=${calon_data.nomor_urut}`)">{{ calon_data.nomor_urut }}.</a></td>
                    <td class="p-2"><a class="w-full block" :href="$setUrl(`/cek-profil/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}/${$slugify(calon_data.nama)}?no_partai=${partai.nomor_urut}&no_calon=${calon_data.nomor_urut}`)"><h5 class="text-xs lg:text-sm">{{ calon_data.nama }}</h5></a></td>
                    <td class="p-2 w-1/12 text-right text-xs lg:text-base"><a class="w-full block" :href="$setUrl(`/cek-profil/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}/${$slugify(calon_data.nama)}?no_partai=${partai.nomor_urut}&no_calon=${calon_data.nomor_urut}`)">{{ data[key].toLocaleString('en-US', { style: 'decimal', }) }}</a></td>
                </tr>
                <tr>
                    <td class="p-2" colspan="2"><h5 class="text-xs lg:text-sm">TOTAL SUARA</h5></td>
                    <td class="p-2 w-1/12 text-right text-xs lg:text-base">{{ data['jml_suara_total'].toLocaleString('en-US', { style: 'decimal', }) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
const props = defineProps({
    partai: Object,
    master_calon: Object,
    data: Object,
    calon: Object,
    dapil: Object
});
</script>