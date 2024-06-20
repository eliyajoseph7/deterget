<div>
    <div class="bg-white shadow-md rounded-lg hover:-translate-y-0.5 duration-700 ease-in-out">
        <div class="h-[50vh]">
            <div class="h-[10%] py-4 px-2 font-bold text-lg text-sky-900">Sales Trend for Last 7 Days</div>
            <div class="salesTrend h-[90%]"></div>
        </div>
    </div>

    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector(".salesTrend"), {
                series: [@json($data['series'])],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                },
                markers: {
                    size: 4
                },
                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: @json($data['categories']),
                    title: {
                        text: 'Days'
                    }
                },
                yaxis: {
                    // type: 'logarithmic',
                    // minorTickInterval: 1,
                    // min: 0,
                    title: {
                        text: 'Total Amount (TSHs)'
                    },
                    labels: {
                        show: true,
                        align: '',
                        minWidth: 0,
                        maxWidth: 160,
                        style: {
                            colors: [],
                            fontSize: '12px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 400,
                            cssClass: 'apexcharts-yaxis-label',
                        },
                        offsetX: 0,
                        offsetY: 0,
                        rotate: 0,
                        formatter: (value) => {
                            return value.toLocaleString('en-US', {minimumFractionDigits: 0}) + ''
                        },
                    }
                },
                tooltip: {
                    x: {
                        // format: 'dd/MM/yy HH:mm'
                    },
                    y: {
                        formatter: undefined,
                        title: {
                            formatter: (seriesName) => seriesName,
                        },
                    },
                }
            }).render();
        });
    </script>
</div>
