<template>
    <div class="flex flex-col max-h-screen min-h-96 overflow-x-auto mb-20">
        <div class="relative shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-base text-left rtl:text-right text-black dark:text-gray-400 border-2">
                <thead class="sticky top-0 text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-1 py-1 md:px-6 md:py-2">
                            Wilayah
                        </th>
                        <th v-for="item, k in master" scope="col" class="px-1 py-1 md:px-6 md:py-2" @click="console.log(item.nama);">
                            <div class="flex justify-end">
                                {{ mapping_nomor_paslon[k] }}&nbsp;
                                <ChevronUpDownIcon class="h-4 w-4" aria-hidden="true"/>
                            </div>
                        </th>
                        <th scope="col" class="px-1 py-1 md:px-6 md:py-2 bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700 text-center" rowspan="2">%</th>
                    </tr>
                    <tr class="bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-1 py-1 md:px-6 md:py-2" v-html="`Total`" />
                        <th v-for="item, k in master" class="px-1 py-1 md:px-6 md:py-2" :class="typeof data.chart[k] == 'number' ? 'text-right': ''" v-html="(typeof data.chart[k] == 'number' ? data.chart[k].toLocaleString('en-US', { style: 'decimal',}) : data.chart[k]) " />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in tableData" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-1 py-1 md:px-6 md:py-2" v-html="row.nama_wilayah" />
                        <td v-for="item, k in master" class="px-1 py-1 md:px-6 md:py-2" :class="typeof row[k] == 'number' ? 'text-right': ''" v-html="(typeof row[k] == 'number' ? row[k].toLocaleString('en-US', { style: 'decimal',}) : row[k]) " />
                        <td class="px-1 py-1 md:px-6 md:py-2 text-center" v-html="`${row.persen}%`" />
                    </tr>
                </tbody>
            </table>
        </div>
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
    for (const k in data_table) {
        const kode = k;
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

const sortBy = (k) => {
  if (k === sortKey.value) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortKey.value = k;
    sortOrder.value = 'asc';
  }
};

const sortedData = computed(() => {
  const k = sortKey.value;
  const order = sortOrder.value === 'asc' ? 1 : -1;

  return [...tableData.value].sort((a, b) => {
    if (a[k] < b[k]) return -order;
    if (a[k] > b[k]) return order;
    return 0;
  });
});

</script>