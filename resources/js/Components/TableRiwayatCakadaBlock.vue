<template>
    <h5 class="font-bold lg:text-lg">{{ title }}</h5>
    <div class="overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200 border-collapse border border-slate-500 mb-4 text-xs md:text-sm lg:text-base">
            <thead>
                <tr>
                    <th v-for="header in dynamicHeaders" :key="header" class="border border-slate-600 p-1">{{ header }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(item, index) in data_riwayat" :key="index">
                    <td v-for="header in dynamicHeaders" :key="header" class="px-1 py-4 border border-slate-700 text-center">{{ item[header] }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</template>
<script>
export default{
    props: {
        data_riwayat : Array,
        title : String,
    },
    computed: {
        // Compute headers dynamically from the first object in the data_riwayat array
        dynamicHeaders() {
            // Check if the array is not empty and return the keys of the first object
            return this.data_riwayat.length > 0 ? Object.keys(this.data_riwayat[0]) : [];
        }
    }
};
</script>