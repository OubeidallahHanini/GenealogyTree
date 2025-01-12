@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>List of People</h1>
        <a href="{{ route('people.create') }}" class="btn btn-primary">Add New Person</a>
        <ul class="list-group mt-3">
            @foreach ($people as $person)
                <li class="list-group-item">
                    {{ $person->name }} - Created by: {{ $person->creator->name }}
                    <a href="{{ route('people.show', $person) }}" class="btn btn-sm btn-secondary float-right">View Details</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
