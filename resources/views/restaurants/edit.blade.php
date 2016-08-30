@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Restaurant</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($restaurant, ['route' => ['restaurants.update', $restaurant->id], 'method' => 'patch']) !!}

            @include('restaurants.fields')

            {!! Form::close() !!}
        </div>
@endsection
