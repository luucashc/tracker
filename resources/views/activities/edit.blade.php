@extends('layouts.header')

@section('content')
<div class="container">
    <form action="{{ route('activity.update', $activity->id )}}" method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <div>
            <label>Name: </label>
            <input type="text" name="name" value="{{ $activity->name }}"  required>
            {{ $errors->first('name') }}
        </div>
        <br>
        <div>
            <button type="submit">Edit </button>
            <a href="{{ route('activity.index')}}">Cancel</a>
        </div>
    </form>
</div>
@endsection
