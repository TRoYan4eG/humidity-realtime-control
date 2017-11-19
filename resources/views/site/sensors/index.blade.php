@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" id="charts">
                    <div class="panel-heading">Measurements</div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Main Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Humidity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Temperature</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div  class="panel-body">
                                <div id="map"  style="width: 100%; height: 450px"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="panel-body">
                                <h4>Temperature:</h4>
                                <canvas id="temperature" width="600" height="450"></canvas>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="panel-body">
                                <h4>Humidity:</h4>
                                <canvas id="humidity" width="600" height="450"></canvas>
                            </div>
                        </div>
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_MAPS_API_KEY")}}&callback=initMap"
            type="text/javascript"></script>
    <script>
        window.onload = function initMap() {
            var uluru = {lat: 46.640, lng: 32.620};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 70,
                center: uluru
            });
        }
    </script>
@endsection
