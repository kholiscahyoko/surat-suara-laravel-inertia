<template>
    <h5 class="font-bold lg:text-lg">{{ title }}</h5>
    <div class="overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200 border-collapse border border-slate-500 mb-4 text-xs md:text-sm lg:text-base">
            <thead>
                <tr>
                    <th v-for="heading_label in data_riwayat[0]" class="border border-slate-600 p-1">{{ heading_label }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="row in data_riwayat.slice(1)">
                    <td v-for="data in row" class="px-1 py-4 border border-slate-700 text-center">
                        {{ data }}
                    </td>
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
};
</script>