@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
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
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        }
        arr = location.href.split('/')
        sensorId = arr[arr.length-1]
        getData = () => {
            $.get(`/sensors/${sensorId}`, (response) => {
                if (response.success) {
                    let temperature = []
                    let humidity = []
                    let dates = []
                    response.sensors.measurements.map(measurement => {
                        temperature.push(measurement.temperature)
                        humidity.push(measurement.humidity)
                        dates.push(measurement.created_at)
                    })
                    const data = {
                        labels: dates,
                        datasets: [
                            {
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
                            }
                        ],
                        elementName: "temperature"
                    };
                    const data2 = {
                        labels: dates,
                        datasets: [
                            {
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
                            }
                        ],
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
