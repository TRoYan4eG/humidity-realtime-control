@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Companies</div>

                    <div class="panel-body">
                        <h4>Choose straw:</h4>
                        @if(count($straws) > 0)
                            @foreach($straws as $straw)
                                <input style="margin-bottom: 5px" type="button" class="straw-button" id="{{$straw->id}}" value="{{$straw->id}}"></br>
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
        const redirectSensors = (event) => {
            window.location = `/sensors/straw/${event.target.id}`
        }
        window.onload = () => {
            const companies = Array.from(document.getElementsByClassName('straw-button'))
            companies.map(item => (
                item.addEventListener('click', redirectSensors)
            ))
        }
    </script>
@endsection
