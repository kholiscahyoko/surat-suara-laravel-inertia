<template>
    <h4 class="text-center font-bold md:text-3xl mt-10" v-html="(nasional ? `Perolehan Suara Nasional`: `Perolehan Suara Dapil ${dapil.nama_dapil}`)"></h4>
    <div class="text-center my-8">
        {{ `Progress: ${data.progres.progres.toLocaleString('en-US', { style: 'decimal',})} dari ${data.progres.total.toLocaleString('en-US', { style: 'decimal',})} TPS (${((data.progres.progres/data.progres.total)*100).toLocaleString('en-US', { style: 'decimal',maximumFractionDigits: 2})}%)` }}<br>
        {{ `Diperbarui: ${getFormattedDate(data.ts)}` }}<br>
        <SumberPemilu2024 /><br>
    </div>
    <!-- Bar Chart -->
    <div class="mx-auto w-full" :id="`bar-chart-${id}`"></div>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue'
import ApexCharts from 'apexcharts'
import SumberPemilu2024 from '../Shared/SumberPemilu2024.vue';
var props = defineProps({
    master : Object,
    data : Object,
    nasional : Boolean,
    id : String,
    dapil : Object,
})
// Array of month names
const months = [
    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
];

const getFormattedDate = function(dateString){
    // Create a new Date object from the given string
    const date = new Date(dateString);

    // Get the day, month, and year components
    const day = date.getDate();
    const monthIndex = date.getMonth();
    const year = date.getFullYear();

    // Format the date string
    const formattedDate = `${day} ${months[monthIndex]} ${year} ${date.toLocaleTimeString('en-US', { hour12: false })}`;

    return formattedDate;
}

var chart = null;

let render_chart = function(){
    let series = function(master_chart, data_chart){
        const modifiedChart = {};
        for (const key in master_chart) {
            let chart = master_chart[key];
            if(data_chart[key]){
                Object.assign(chart, {jumlah_suara : data_chart[key]});
                modifiedChart['d' + key] = chart;
            }
        }

        const chartArray = Object.entries(modifiedChart);
        const sortedChart = [];
        chartArray.forEach(([key, value]) => {
            sortedChart.push({
                x: `${value.nomor_urut}. ${value.nama}`,
                y: value.jumlah_suara,
            });
        });
        return sortedChart;
    }
    
    let getX = function(array){
        let newarray = [];

        for (let index = 0; index < array.length; index++) {
            newarray.push(array[index].x);
        }

        return newarray;
    }

    let getY = function(array, percent = false){
        let newarray = [];

        for (let index = 0; index < array.length; index++) {
            if(percent){
                newarray.push(getPercentage(array[index].y));
            }else{
                newarray.push(array[index].y);
            }
        }
        return newarray;
    }

    let labels = function(master_chart){
        return Object.values(master_chart).map(item => {
            // Return the label or a default value if not found
            return item.nama ? item.nama : 'Unknown';
        });
    }

    let getPercentage = function(input){
        let total = 0;
        for (const key in props.data.chart) {
            if(!isNaN(key)){
                total = total + props.data.chart[key];
            }
        }
        let result = (input * 100) / total;
        return result;
    }

    let colors = function(master_chart, data){
        let colors = [];

        // Repeat elements from the original array
        for (const key in data){
            if(!isNaN(key)){
                colors.push(master_chart[key].warna);
            }
        }

        return colors;
    }

    let data = series(props.master, props.data.chart);

    let options = {
        chart: {
              type: 'bar',
              height: 640
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                columnWidth: 40,
                distributed: true,
                horizontal: false,
                borderRadiusApplication : 'end',
                borderRadiusWhenStacked : 'last',
                dataLabels: {
                    position: 'bottom'
                },
            }
        },
        legend:{show: true},
        dataLabels: {
            enabled: false
        },
        colors: colors(props.master, props.data.chart),
        dataLabels: {
            enabled: false,
            textAnchor: 'end',
            style: {
                colors: ['#000']
            },
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex]
            },
            offsetX: 0,
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        series: [
            {
                data: getY(data, true)
            }
        ],
        xaxis: {
            labels: {
                show : false
            },
            categories: getX(data),
        },
        yaxis: {
            labels: {
                show: true,
                formatter: function (val) {
                    return `${val} %`
                }
            }
        },
        tooltip: {
            theme: 'dark',
            x: {
                show: true
            },
            y: {
                formatter: function (val, opt) {
                    return data[opt.dataPointIndex].y.toLocaleString('en-US', {
                            style: 'decimal',
                        }) + ` (${val.toLocaleString('en-US', {
                            style: 'decimal',
                            maximumFractionDigits: 2
                        })} %) `
                },
                title: {
                    formatter: function () {
                    return ''
                    }
                }
            }
        },
        responsive: [
            {
                breakpoint: 1024,
                options: {
                    plotOptions:{
                        bar: {
                            barHeight: '100%',
                            columnWidth: 30,
                        }
                    }
                }
            },
            {
                breakpoint: 640,
                options: {
                    plotOptions:{
                        bar: {
                            barHeight: '100%',
                            columnWidth: 20,
                        }
                    }
                }
            },
            {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 480
                    },
                    plotOptions:{
                        bar: {
                            barHeight: '100%',
                            columnWidth: 15,
                        }
                    }
                }
            },
        ],
    }

    if(props.nasional){
        options.annotations = {
            yaxis: [
                {
                    y: 4,
                    borderColor: '#00E396',
                    borderWidth: 1,
                    strokeDashArray: 8,
                }
            ],
        }
    }
    chart = new ApexCharts(document.getElementById(`bar-chart-${props.id}`), options);
    chart.render();
}

onMounted(() => {
    render_chart();
})

onUnmounted(() => {
    chart.destroy();
})

</script>