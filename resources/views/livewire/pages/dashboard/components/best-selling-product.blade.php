<div>
    <div class="bg-white shadow-md rounded-lg hover:-translate-y-0.5 duration-700 ease-in-out">
        <div class="h-[50vh]">
            <div class="h-[10%] py-4 px-2 font-bold text-lg text-sky-900">Best Selling Products</div>
            <div class="bestSellingProduct h-[90%]"></div>
        </div>
    </div>

    <script>

        document.addEventListener("DOMContentLoaded", () => {
            drawChart()
        });


        function drawChart() {
            // console.log(@json($data));
            $('.bestSellingProduct').highcharts({
                chart: {
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
                    valueSuffix: '%'
                },
                subtitle: {
                    text: ''
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: [{
                            enabled: true,
                            distance: 20
                        }, {
                            enabled: true,
                            distance: -40,
                            format: '{point.percentage:.1f}%',
                            style: {
                                fontSize: '1.2em',
                                textOutline: 'none',
                                opacity: 0.7
                            },
                            filter: {
                                operator: '>',
                                property: 'percentage',
                                value: 10
                            }
                        }]
                    }
                },
                series: @json($data)
            });
        }
    </script>
</div>
