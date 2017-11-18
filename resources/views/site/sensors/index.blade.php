@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" id="charts">
                    <div class="panel-heading">Measurements</div>
                    <div class="panel-body">
                        <h4>Temperature:</h4>
                        <canvas id="temperature" width="600" height="400"></canvas>
                        <h4>Humidity:</h4>
                        <canvas id="humidity" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const buildChart = (data) => {
            const ctx = document.getElementById(data.elementName);
            const mainChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
        arr = location.href.split('/')
        sensorId = arr[arr.length - 1]
        getData = () => {
            $.get(`/sensors/${sensorId}`, (response) => {
                if (response.success) {
                    let dataSet1 = []
                    let dataSet2 = []
                    let dates = []
                    response.sensors.map(sensor => {
                        let temperature = []
                        let humidity = []
                        sensor.measurements.map(measurement => {
                            temperature.push(measurement.temperature)
                            humidity.push(measurement.humidity)
                        })
                            dataSet1.push({
                                label: "Temperature",
                                fill: true,
                                lineTension: 0.1,
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgba(255,99,132,1)",
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: "rgba(255,99,132,1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(255,99,132,1)",
                                pointHoverBorderColor: "rgba(255,99,132,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: temperature,
                                spanGaps: false,
                            })
                            dataSet2.push({
                                label: "Humidity",
                                fill: true,
                                lineTension: 0.1,
                                backgroundColor: "rgba(75,192,192,0.4)",
                                borderColor: "rgba(75,192,192,1)",
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: "rgba(75,192,192,1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: humidity,
                                spanGaps: false,
                            })
                    })
                    console.log(dataSet1)
                    response.sensors[0].measurements.map(measurement => {
                        dates.push(measurement.created_at)
                    })
                    const data = {
                        labels: dates,
                        datasets: dataSet1,
                        elementName: "temperature"
                    };
                    const data2 = {
                        labels: dates,
                        datasets: dataSet2,
                        elementName: "humidity"
                    };
                    buildChart(data)
                    buildChart(data2)
                    setTimeout(getData, 60000)
                }
            })
        }
        window.onload = getData
    </script>
@endsection
