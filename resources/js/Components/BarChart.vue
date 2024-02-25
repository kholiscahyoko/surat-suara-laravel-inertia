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
    calon: Object,
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
        console.log(sortedChart);
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
        for (const key in props.master) {
            total = total + props.data.chart[key];
        }
        let result = (input * 100) / total;
        return result;
    }

    let colors = function(master_chart, threshold, data){
        let colors = [];
    
        // Repeat elements from the original array
        for (let i = 0; i < threshold; i++) {
            colors.push('#90ee7e');
        }
        colors = master_chart.length > colors.length ? colors.concat(Array(master_chart.length - colors.length).fill('#d4526e')) : colors;

        if(props.calon && props.calon.no_urut){
            const pattern = new RegExp(`\\((${props.calon.no_urut})\\)`)
            for (let index = 0; index < data.length; index++) {
                let matches = data[index].x.match(pattern);
                // if(data[index].nomor_urut == props.calon.no_urut){
                //     colors[index] = '#faca15';
                // }
                if(matches && matches.length > 1){
                    colors[index] = '#faca15';
                }
            }
        }

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
                barHeight: '99%',
                distributed: true,
                horizontal: true,
                borderRadius: 10,
                borderRadiusApplication : 'end',
                borderRadiusWhenStacked : 'last',
                dataLabels: {
                    position: 'bottom'
                },
            }
        },
        legend:{show: false},
        dataLabels: {
            enabled: false
        },
        colors: colors(Object.entries(props.master), 4, data),
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#000']
            },
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + data[opt.dataPointIndex].y.toLocaleString('en-US', {
                        style: 'decimal',
                    }) + ` (${val.toLocaleString('en-US', {
                        style: 'decimal',
                        maximumFractionDigits: 2
                    })} %) `
            },
            offsetX: -60,
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
        }
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