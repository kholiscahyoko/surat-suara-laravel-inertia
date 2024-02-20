<template>
    <!-- Pie Chart -->
    <div class="mx-auto" id="pie-chart"></div>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue'
import ApexCharts from 'apexcharts'
var props = defineProps({
    master : Object,
    data : Object,
})

var chart = null;

let render_chart = function(){
    let data_chart = props.data.chart;
    let master_chart = props.master;
    let series = function(keys, data_chart){
        return keys.map(item => {
            return data_chart[item];
        });
    }
    let labels = function(master_chart){
        return Object.values(master_chart).map(item => {
            // Return the label or a default value if not found
            return item.nama ? item.nama : 'Unknown';
        });
    }
    let colors = function(master_chart){
        return Object.values(master_chart).map(item => {
            // Return the label or a default value if not found
            return item.warna ? item.warna : '#FFFFFF';
        });
    }
    let options = {
        series: series(Object.keys(master_chart), data_chart),
        colors: colors(master_chart),
        chart: {
            width: 1000,
            type: "pie",
        },
        labels: labels(master_chart),
        responsive: [
            {
                breakpoint: 1024,
                    options: {
                    chart: {
                        width: 640
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '12px'
                    }
                }
            },
            {
                breakpoint: 640,
                    options: {
                    chart: {
                        width: 500
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '10px'
                    }
                }
            },
            {
                breakpoint: 480,
                    options: {
                    chart: {
                        width: 400
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '10px'
                    }
                }
            },
        ],
        stroke: {
            colors: ["white"],
            lineCap: "",
            width:1,
        },
        dataLabels: {
            enabled: true,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "right",
            fontFamily: "Inter, sans-serif"
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
    chart = new ApexCharts(document.getElementById("pie-chart"), options);
    chart.render();
}

onMounted(() => {
    render_chart();
})

onUnmounted(() => {
    chart.destroy();
})

</script>