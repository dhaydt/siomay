@extends('dashboard.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                Beranda Dashboard
            </div>
            {{-- <div class="card-toolbar">
                <button class="btn btn-primary btn-tambah-layanan" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Tambah Role Untuk Layanan"><i class="fas fa-plus-circle"></i> Tambah</button>
            </div> --}}
        </div>
        <div class="card-body">
            @livewire('dashboard.index')
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){

            // Pie Chart
            am5.ready(function () {
                var root = am5.Root.new("kt_amcharts_3");

                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                var chart = root.container.children.push(am5percent.PieChart.new(root, {
                    layout: root.verticalLayout
                }));

                var series = chart.series.push(am5percent.PieSeries.new(root, {
                    alignLabels: true,
                    calculateAggregates: true,
                    valueField: "value",
                    categoryField: "category"
                }));

                series.slices.template.setAll({
                    strokeWidth: 3,
                    stroke: am5.color(0xffffff)
                });

                series.labelsContainer.set("paddingTop", 30)

                series.slices.template.adapters.add("radius", function (radius, target) {
                    var dataItem = target.dataItem;
                    var high = series.getPrivate("valueHigh");

                    if (dataItem) {
                        var value = target.dataItem.get("valueWorking", 0);
                        return radius * value / high
                    }
                    return radius;
                });

                series.data.setAll([{
                    value: 10,
                    category: "One"
                }, {
                    value: 9,
                    category: "Two"
                }, {
                    value: 6,
                    category: "Three"
                }, {
                    value: 5,
                    category: "Four"
                }, {
                    value: 4,
                    category: "Five"
                }, {
                    value: 3,
                    category: "Six"
                }]);

                var legend = chart.children.push(am5.Legend.new(root, {
                    centerX: am5.p50,
                    x: am5.p50,
                    marginTop: 15,
                    marginBottom: 15
                }));

                legend.data.setAll(series.dataItems);

                series.appear(1000, 100);

            }); // end Pie Chart


            // Gauge Chart
            am5.ready(function () {
                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("kt_amcharts_5");

                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                // Create chart
                // https://www.amcharts.com/docs/v5/charts/radar-chart/
                var chart = root.container.children.push(am5radar.RadarChart.new(root, {
                    panX: false,
                    panY: false,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    innerRadius: am5.percent(20),
                    startAngle: -90,
                    endAngle: 180
                }));

                // Data
                var data = [{
                    category: "Research",
                    value: 80,
                    full: 100,
                    columnSettings: {
                        fill: chart.get("colors").getIndex(0)
                    }
                }, {
                    category: "Marketing",
                    value: 35,
                    full: 100,
                    columnSettings: {
                        fill: chart.get("colors").getIndex(1)
                    }
                }, {
                    category: "Distribution",
                    value: 92,
                    full: 100,
                    columnSettings: {
                        fill: chart.get("colors").getIndex(2)
                    }
                }, {
                    category: "Human Resources",
                    value: 68,
                    full: 100,
                    columnSettings: {
                        fill: chart.get("colors").getIndex(3)
                    }
                }];

                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/radar-chart/#Cursor
                var cursor = chart.set("cursor", am5radar.RadarCursor.new(root, {
                    behavior: "zoomX"
                }));

                cursor.lineY.set("visible", false);

                // Create axes and their renderers
                // https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_axes
                var xRenderer = am5radar.AxisRendererCircular.new(root, {
                    //minGridDistance: 50
                });

                xRenderer.labels.template.setAll({
                    radius: 10
                });

                xRenderer.grid.template.setAll({
                    forceHidden: true
                });

                var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: xRenderer,
                    min: 0,
                    max: 100,
                    strictMinMax: true,
                    numberFormat: "#'%'",
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yRenderer = am5radar.AxisRendererRadial.new(root, {
                    minGridDistance: 20
                });

                yRenderer.labels.template.setAll({
                    centerX: am5.p100,
                    fontWeight: "500",
                    fontSize: 18,
                    templateField: "columnSettings"
                });

                yRenderer.grid.template.setAll({
                    forceHidden: true
                });

                var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "category",
                    renderer: yRenderer
                }));

                yAxis.data.setAll(data);

                // Create series
                // https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_series
                var series1 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
                    xAxis: xAxis,
                    yAxis: yAxis,
                    clustered: false,
                    valueXField: "full",
                    categoryYField: "category",
                    fill: root.interfaceColors.get("alternativeBackground")
                }));

                series1.columns.template.setAll({
                    width: am5.p100,
                    fillOpacity: 0.08,
                    strokeOpacity: 0,
                    cornerRadius: 20
                });

                series1.data.setAll(data);

                var series2 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
                    xAxis: xAxis,
                    yAxis: yAxis,
                    clustered: false,
                    valueXField: "value",
                    categoryYField: "category"
                }));

                series2.columns.template.setAll({
                    width: am5.p100,
                    strokeOpacity: 0,
                    tooltipText: "{category}: {valueX}%",
                    cornerRadius: 20,
                    templateField: "columnSettings"
                });

                series2.data.setAll(data);

                // Animate chart and series in
                // https://www.amcharts.com/docs/v5/concepts/animations/#Initial_animation
                series1.appear(1000);
                series2.appear(1000);
                chart.appear(1000, 100);
            }); //End Gauge Chart
        })
    </script>
@endpush
