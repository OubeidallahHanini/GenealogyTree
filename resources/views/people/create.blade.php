@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create a New Person</h1>
        <form action="{{ route('people.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="created_by">Created By User ID</label>
                <input type="number" class="form-control" id="created_by" name="created_by" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
