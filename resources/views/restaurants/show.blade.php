@extends('layouts.app')

@section('content')
    @include('restaurants.show_fields')

    <div class="form-group">
           <a href="{!! route('restaurants.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
