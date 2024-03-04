<template>
    <h5 class="font-bold lg:text-lg">{{ title }}</h5>
    <div class="overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200 border-collapse border border-slate-500 mb-4 text-xs md:text-sm lg:text-base">
            <thead>
                <tr>
                    <template v-for="heading_label, i in data_riwayat[0]">
                        <th v-if="title!=='RIWAYAT PASANGAN' || i === 1" class="border border-slate-600 p-1">{{ heading_label }}</th>
                    </template>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="row in data_riwayat.slice(1)">
                    <template v-for="data, i in row">
                        <td v-if="title!=='RIWAYAT PASANGAN' || i === 1" class="px-1 py-4 border border-slate-700 text-center">
                            {{ data }}
                        </td>
                    </template>
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