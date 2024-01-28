<template>
<div class="md:flex justify-center">
    <div class="bg-gray-300 rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 m-3">
        <h3 class="text-center font-bold text-lg">Proporsi jumlah calon berdasarkan jenis kelamin</h3>
        <!-- Pie Chart Jenis Kelamin -->
        <div class="max-w-64 mx-auto" id="jenis-kelamin"></div>
    </div>
    <div class="bg-gray-300 rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 m-3">
        <h3 class="text-center font-bold text-lg">Jumlah calon legislatif berdasarkan kategori</h3>
        <!-- Line Chart Jenis Dewan-->
        <div class="flex flex-wrap items-center justify-center max-w-md">
            <div class="min-w-52 bg-red-600 p-4 m-1 text-center text-white rounded-lg font-bold flex-shrink-0 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
                <h3 class="text-sm">DPD RI</h3>
                <h4 class="text-2xl">{{ summary.jenis_dewan.dpd }}</h4>
            </div>
            <div class="min-w-52 bg-yellow-400 p-4 m-1 text-center text-black rounded-lg font-bold flex-shrink-0 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
                <h3 class="text-sm">DPD RI</h3>
                <h4 class="text-2xl">{{ summary.jenis_dewan.dpr }}</h4>
            </div>
            <div class="min-w-52 bg-blue-600 p-4 m-1 text-center text-white rounded-lg font-bold flex-shrink-0 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
                <h3 class="text-sm">DPD RI</h3>
                <h4 class="text-2xl">{{ summary.jenis_dewan.dprdp }}</h4>
            </div>
            <div class="min-w-52 bg-green-600 p-4 m-1 text-center text-white rounded-lg font-bold flex-shrink-0 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">
                <h3 class="text-sm">DPD RI</h3>
                <h4 class="text-2xl">{{ summary.jenis_dewan.dprdk }}</h4>
            </div>
        </div>
    </div>
</div>
</template>
<script setup>
import { onMounted } from 'vue'
import ApexCharts from 'apexcharts'
var props = defineProps({
    summary : Object
})

let configs_jenis_kelamin = {
    'LAKI - LAKI' : {
        color : "#1C64F2",
        label : "Laki-laki"
    },
    'PEREMPUAN' : {
        color : "#DE3163",
        label : "Perempuan"
    },
}

let render_jenis_kelamin = function(){
    let jenis_kelamin = props.summary.jenis_kelamin;
    let series = function(jenis_kelamin){
        return jenis_kelamin.map(item => {
            return item.jumlah;
        });
    }
    let labels = function(configs, jenis_kelamin){
        return jenis_kelamin.map(item => {
            const jenisKelamin = item.jenis_kelamin;
            const config = configs[jenisKelamin];
            
            // Return the label or a default value if not found
            return config ? config.label : 'Unknown';
        });
    }
    let colors = function(configs, jenis_kelamin){
        return jenis_kelamin.map(item => {
            const jenisKelamin = item.jenis_kelamin;
            const config = configs[jenisKelamin];
            
            // Return the label or a default value if not found
            return config ? config.color : 'Unknown';
        });
    }
    let options = {
        series: series(jenis_kelamin),
        colors: colors(configs_jenis_kelamin, jenis_kelamin),
        chart: {
            height: 420,
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: ["yellow"],
            lineCap: "",
        },
        plotOptions: {
            pie: {
                labels: {
                    show: true,
                },
                size: "100%",
                    dataLabels: {
                    offset: -25
                }
            },
        },
        labels: labels(configs_jenis_kelamin, jenis_kelamin),
        dataLabels: {
            enabled: true,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value.toLocaleString('en-US', {
                        style: 'decimal',
                    })
                },
            },
        },
        xaxis: {
            labels: {
                formatter: function (value) {
                    return value
                },
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
    }
    let chart = new ApexCharts(document.getElementById("jenis-kelamin"), options);
    chart.render();
}

onMounted(() => {
    render_jenis_kelamin();
})
</script>