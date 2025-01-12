@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $person->name }}</h1>
        <p>Created by: {{ $person->creator->name }}</p>
        <h3>Children:</h3>
        <ul>
            @foreach ($person->children as $child)
                <li>{{ $child->name }}</li>
            @endforeach
        </ul>
        <h3>Parents:</h3>
        <ul>
            @foreach ($person->parents as $parent)
                <li>{{ $parent->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
