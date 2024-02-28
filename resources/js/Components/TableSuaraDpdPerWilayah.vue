<template>
    <div class="flex flex-col max-h-screen min-h-96 overflow-x-auto mb-20">
        <div class="relative shadow-md sm:rounded-lg">
        <table class="min-w-full divide-y text-xs md:text-base text-left rtl:text-right text-black dark:text-gray-400 border-2">
            <thead class="sticky top-0 text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 z-10">
                <tr>
                    <th scope="col" class="sticky left-0 bg-white px-1 py-1 md:px-6 md:py-2  border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                        Nama
                    </th>
                    <th scope="col" class="bg-white px-1 py-1 md:px-6 md:py-2">
                        Total
                    </th>
                    <th v-for="item, key in wilayah" scope="col" class="px-1 py-1 md:px-6 md:py-2" @click="console.log(item.nama);">
                        {{ item.nama }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item, kode_calon in master" class="border-b dark:bg-gray-800 dark:border-gray-700" :class="calon && calon.no_urut && calon.no_urut == item.nomor_urut ? 'bg-yellow-300 font-semibold':''">
                    <td class="sticky left-0 px-1 py-1 md:px-6 md:py-2"  :class="calon && calon.no_urut && calon.no_urut == item.nomor_urut ? 'bg-yellow-300':'bg-white'">
                        <a class="hover:text-indigo-700" :href="$setUrl(`/cek-profil/dpd/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}/${$slugify(item.nama)}?no_calon=${item.nomor_urut}`)">
                            <div class="flex space-x-3 items-center">
                                <div>
                                    {{ item.nomor_urut }}
                                </div>
                                <div>
                                    {{ item.nama }}
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="px-1 py-1 md:px-6 md:py-2 text-right" v-html="data.chart[kode_calon].toLocaleString('en-US', { style: 'decimal',})" />
                    <td v-for="item, key in wilayah" class="px-1 py-1 md:px-6 md:py-2 text-right" v-html=" data.table[item.kode][kode_calon].toLocaleString('en-US', { style: 'decimal',}) " />
                </tr>
            </tbody>
            <tfoot class="sticky bottom-0 text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700">
                    <th class="sticky left-0 bg-gray-200 dark:bg-gray-800 px-1 py-1 md:px-6 md:py-2 text-center" v-html="`Total`" />
                    <th class="px-1 py-1 md:px-6 md:py-2 text-right" v-html="get_total().toLocaleString('en-US', { style: 'decimal',})" />
                    <th v-for="item, key in wilayah" class="px-1 py-1 md:px-6 md:py-2 text-right" v-html="get_total_per_wilayah(item.kode).toLocaleString('en-US', { style: 'decimal',}) " />
                </tr>
                <tr class="bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700">
                    <th class="sticky left-0 bg-gray-200 dark:bg-gray-800 px-1 py-1 md:px-6 md:py-2 text-center" v-html="`Progress`" />
                    <th class="px-1 py-1 md:px-6 md:py-2 text-right" v-html="`${data.chart.persen}%`" />
                    <th v-for="item, key in wilayah" class="px-1 py-1 md:px-6 md:py-2 text-right" v-html="`${data.table[item.kode].persen}%`" />
                </tr>
            </tfoot>
        </table>
    </div>

    </div>
</template>
<script setup>
import { ref, computed } from 'vue';
let props = defineProps({
    master : Object,
    data : Object,
    wilayah : Object,
    calon: Object,
    dapil: Object,
});

let mapping_nomor_paslon = {
    '100025' : '01',
    '100026' : '02',
    '100027' : '03',
}

let default_table = function(data_wilayah, data_table){
    let data = [];
    for (const key in props.master) {
        const kode_calon = key;
        // const element = data_table.find(item => item.kode === kode);

        // let wilayah = data_wilayah[kode];
        // wilayah.kode_wilayah = element.kode;
        // wilayah.nama_wilayah = element.nama;

        // data.push(wilayah);
    }

    return data;
}

let get_total_per_wilayah = function(kode_wilayah){
    let total = 0;
    for (const key in props.data.table[kode_wilayah]) {
        const kode = key;
        for (const key_master in props.master) {
            if(key === key_master){
                total = total + props.data.table[kode_wilayah][key];
            }
        }
    }

    return total;
}

let get_total_per_calon = function(kode_calon){
    let total = 0;
    for (const key in props.data.table[kode_wilayah]) {
        const kode = key;
        for (const key_master in props.master) {
            if(key === key_master){
                total = total + props.data.table[kode_wilayah][key];
            }
        }
    }

    return total;
}

let get_total = function(){
    let total = 0;
    for (const key in props.data.chart) {
        const kode = key;
        for (const key_master in props.master) {
            if(key === key_master){
                total = total + props.data.chart[key];
            }
        }
    }

    return total;
}

let tableData = ref(default_table(props.wilayah, props.data.table));

const sortKey = ref('');
const sortOrder = ref('asc');

const sortBy = (key) => {
  if (key === sortKey.value) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortKey.value = key;
    sortOrder.value = 'asc';
  }
};

const sortedData = computed(() => {
  const key = sortKey.value;
  const order = sortOrder.value === 'asc' ? 1 : -1;

  return [...tableData.value].sort((a, b) => {
    if (a[key] < b[key]) return -order;
    if (a[key] > b[key]) return order;
    return 0;
  });
});

</script>