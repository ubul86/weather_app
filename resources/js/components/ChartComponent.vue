<template>
    <LineChartGenerator
        :chart-data="chartData"
        :chart-options="chartOptions"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height"
    />
</template>

<script>
import { Line as LineChartGenerator } from 'vue-chartjs/legacy'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
} from 'chart.js'

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
)

export default {
    name: 'LineChart',
    components: {
        LineChartGenerator
    },
    props: {
        chartId: {
            type: String,
            default: 'line-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => ({})
        },
        plugins: {
            type: Array,
            default: () => []
        },
        weatherData: {
            type: Object,
            default: () => ({})
        }
    },
    computed: {
        chartData() {
            if (!this.weatherData.hourly || !this.weatherData.hourly.time || !this.weatherData.hourly.temperature_2m || !this.weatherData.hourly.relative_humidity_2m) {
                return {
                    labels: [],
                    datasets: []
                }
            }

            return {
                labels: this.weatherData.hourly.time.map(t => new Date(t).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })),
                datasets: [
                    {
                        label: 'Hourly Temperature',
                        data: this.weatherData.hourly.temperature_2m,
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Hourly Relative Humidity',
                        data: this.weatherData.hourly.relative_humidity_2m,
                        borderColor: '#FF6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }
                ]
            }
        },
        chartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Time'
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        }
    }
}
</script>
