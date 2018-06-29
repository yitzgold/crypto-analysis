@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div>{!! $chart->render()!!}</div>
            </div>
        </div>
    </div>
@endsection
