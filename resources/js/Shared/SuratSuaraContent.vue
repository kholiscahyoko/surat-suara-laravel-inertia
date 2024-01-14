<template>
    <div class="flex flex-wrap justify-center">
        <div v-for="surat_suara in surat_suaras" class="w-64 bg-white rounded-lg overflow-hidden shadow-xl shadow-slate-600 mr-4 mb-10 border border-2 border-slate-950">
            <div class="flex items-center px-4 py-4 border-b border-black">
                <div class="font-bold w-5 h-5 text-2xl">{{ surat_suara.no }}</div>
                <img v-bind:src="`assets/img/partai/${surat_suara.no}.webp`" class="w-20 h-20 mx-2" alt="">
                <div class="font-semibold text-wrap text-sm">{{ surat_suara.name }}</div>
            </div>
            <table>
                <tbody class="divide-y divide-dashed divide-gray-600">
                    <tr v-for="calon in calons">
                        <td class="p-2 w-1/12">{{ calon.no }}.</td>
                        <td class="p-2 text-sm">{{ calon.name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>
let surat_suaras = [
    { name : 'PARTAI KEBANGKITAN BANGSA', no : 1 },
    { name : 'PARTAI GERINDRA', no : 2 },
    { name : 'PDI PERJUANGAN', no : 3 },
    { name : 'PARTAI GOLKAR', no : 4 },
    { name : 'Partai NasDem', no : 5 },
]

let calons = [
    { name : 'ANTONIOS NIKOPOLIDIS', no : 1 },
    { name : 'GIOURKAS SEITARIDIS', no : 2 },
    { name : 'STYLIANOS VENETIDIS', no : 3 },
    { name : 'NIKOS DABIZAS', no : 4 },
    { name : 'TRAIANOS DELLAS', no : 5 },
    { name : 'ANGELOS BASINAS', no : 6 },
    { name : 'THEODOROS ZAGORAKIS', no : 7 },
    { name : 'STELIOS GIANNAKOPOULOS', no : 8 },
    { name : 'ANGELOS CHARISTEAS', no : 9 },
    { name : 'VASILLOS TSIARTAS', no : 10 },
    { name : 'DEMIS NIKOLAIDIS', no : 11 },
]
</script>