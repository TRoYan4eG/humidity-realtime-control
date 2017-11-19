@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Straws</div>

                    <div class="panel-body">
                        <h4>Choose straw:</h4>
                        @if(count($straws) > 0)
                            @foreach($straws as $straw)
                                <div class="card">
                                    <div class="card-header">
                                        У Васька на поле
                                    </div>
                                    <div class="card-body">
                                        <img class="pull-right img-rounded" style="margin-right: 10px" width="150px" height="150px"
                                             src="{{asset('images/test2.jpg')}}" alt="Card image cap">
                                        <p class="card-text">Разстелили лён у васька на поле 19ю11ю2017d  dskffdfk skldfksdk fksdk  kfksd ksfdkkfksldk fksd kfk ksdkfskd ksdkf ldsl kdkf kdskl kfsdk klfdkls f</p>
                                        <a href="/sensors/straw/{{$straw->id}}" class="btn btn-primary">Go to straw</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            You have no straws!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const redirectSensors = (event) => window.location = `/sensors/straw/${event.target.id}`
        window.onload = () => {
            const companies = Array.from(document.getElementsByClassName('straw-button'))
            companies.map(item => (
                item.addEventListener('click', redirectSensors)
            ))
        }
    </script>
@endsection
