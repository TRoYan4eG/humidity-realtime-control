@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Companies</div>

                    <div class="panel-body">
                        <h4>Choose your company:</h4>
                        @if(count($companies) > 0)
                            @foreach($companies as $company)
                                <input style="margin-bottom: 5px" type="button" class="company-button" id="{{$company->id}}" value="{{$company->name}}"></br>
                            @endforeach
                        @else
                        You have no companies!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const redirectStraw = (event) => {
            window.location = `/straws/company/${event.target.id}`
        }
        window.onload = () => {
            const companies = Array.from(document.getElementsByClassName('company-button'))
            companies.map(item => (
                item.addEventListener('click', redirectStraw)
            ))
        }

    </script>
@endsection
