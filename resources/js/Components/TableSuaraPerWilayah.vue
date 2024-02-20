<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-xs md:text-base text-left rtl:text-right text-gray-500 dark:text-gray-400 border-2">
            <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Wilayah
                    </th>
                    <th v-for="item, key in master" scope="col" class="px-6 py-3" @click="console.log(item.nama);">
                        <div class="flex justify-end">
                            {{ mapping_nomor_paslon[key] }}&nbsp;
                            <ChevronUpDownIcon class="h-4 w-4" aria-hidden="true"/>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700 text-center" rowspan="2">Progress</th>
                </tr>
                <tr class="bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700">
                    <th class="px-6 py-4" v-html="`Total`" />
                    <th v-for="item, key in master" class="px-6 py-4" :class="typeof data.chart[key] == 'number' ? 'text-right': ''" v-html="(typeof data.chart[key] == 'number' ? data.chart[key].toLocaleString('en-US', { style: 'decimal',}) : data.chart[key]) " />
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in tableData" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4" v-html="row.nama_wilayah" />
                    <td v-for="item, key in master" class="px-6 py-4" :class="typeof row[key] == 'number' ? 'text-right': ''" v-html="(typeof row[key] == 'number' ? row[key].toLocaleString('en-US', { style: 'decimal',}) : row[key]) " />
                    <td class="px-6 py-4 text-center" v-html="`${row.persen}%`" />
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import { ref, computed } from 'vue';
import { ChevronUpDownIcon, ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/24/outline'
let props = defineProps({
    master : Object,
    data : Object,
    wilayah : Object
});

let mapping_nomor_paslon = {
    '100025' : '01',
    '100026' : '02',
    '100027' : '03',
}

let default_table = function(data_wilayah, data_table){
    let data = [];
    for (const key in data_table) {
        const kode = key;
        const element = data_wilayah.find(item => item.kode === kode);

        let wilayah = data_table[kode];
        wilayah.kode_wilayah = element.kode;
        wilayah.nama_wilayah = element.nama;

        data.push(wilayah);

    }

    return data;
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