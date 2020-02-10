@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h2>Car info</h2>
                    </div>
                    <div class="card-body">
                        @if($auth)
                            <car-form :user="{{ (string) $auth->id }}" :car="{{ $car }}" :brands="{{ $brands }}" :models="{{ $models }}"></car-form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


