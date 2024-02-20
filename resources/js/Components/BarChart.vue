<template>
    <!-- Bar Chart -->
    <div class="mx-auto w-full" id="bar-chart"></div>
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
    let series = function(master_chart, data_chart){
        const modifiedChart = {};
        for (const key in master_chart) {
            let chart = master_chart[key];
            Object.assign(chart, {jumlah_suara : data_chart[key]});
            modifiedChart['d' + key] = chart;
        }

        const chartArray = Object.entries(modifiedChart);
        chartArray.sort((a, b) => b[1]['jumlah_suara'] - a[1]['jumlah_suara']);
        const sortedChart = [];
        chartArray.forEach(([key, value]) => {
            sortedChart.push({
                x: `(${value.nomor_urut}) ${value.nama}`,
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

    let getY = function(array){
        let newarray = [];

        for (let index = 0; index < array.length; index++) {
            newarray.push(array[index].y);
        }
        return newarray;
    }

    let labels = function(master_chart){
        return Object.values(master_chart).map(item => {
            // Return the label or a default value if not found
            return item.nama ? item.nama : 'Unknown';
        });
    }

    let colors = function(master_chart, threshold){
        console.log(master_chart);
        let colors = [];
    
        // Repeat elements from the original array
        for (let i = 0; i < threshold; i++) {
            colors.push('#90ee7e');
        }
        // // Fill remaining elements with a different value
        // const remaining = master_chart.length - (threshold * master_chart.length);
        // if (remaining > 0) {
        //     colors.push(...Array(remaining).fill('#d4526e'));
        // }
        colors = master_chart.length > colors.length ? colors.concat(Array(master_chart.length - colors.length).fill('#d4526e')) : colors;
        console.log(colors);
        console.log(master_chart.length);

        return colors;
    }

    let data = series(props.master, props.data.chart);

    let options = {
        chart: {
              type: 'bar',
              height: (data.length * 30)
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                distributed: true,
                horizontal: true,
                dataLabels: {
                    position: 'bottom'
                },
            }
        },
        legend:{show: false},
        dataLabels: {
            enabled: false
        },
        colors: colors(Object.entries(props.master), 4),
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#000']
            },
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val.toLocaleString('en-US', {
                        style: 'decimal',
                    })
            },
            offsetX: 0,
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        series: [
            {
                data: getY(data)
            }
        ],
        xaxis: {
            categories: getX(data),
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        tooltip: {
            theme: 'dark',
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function () {
                    return ''
                    }
                }
            }
        }
        // ,responsive: [
        //     {
        //         breakpoint: 1024,
        //         options: {
        //             chart: {
        //                 height: 640
        //             },
        //         }
        //     },
        //     {
        //         breakpoint: 640,
        //         options: {
        //             chart: {
        //                 height: 640
        //             },
        //         }
        //     },
        //     {
        //         breakpoint: 480,
        //         options: {
        //             chart: {
        //                 height: 640
        //             },
        //         }
        //     },
        // ],
    }
    chart = new ApexCharts(document.getElementById("bar-chart"), options);
    chart.render();
}

onMounted(() => {
    render_chart();
})

onUnmounted(() => {
    chart.destroy();
})

</script>