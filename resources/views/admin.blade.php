@extends('layouts.main')

@section('title', 'Admin')

@section('content')
    <form action="{{route('admin.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <p>Maintenance Mode:</p>
            <div class="form-group">
                <input type="radio" name="toggle" id="true" value="1">
                <label for="true" class="form-label">True</label>
                <input type="radio" name="toggle" id="false" value="0">
                <label for="false" class="form-label">False</label>
            </div>
            @error('toggle')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
    <hr>
    <form action="{{route('admin.email')}}" method="POST">
        @csrf
        <p>Newsletter:</p>
        <button type="submit" class="btn btn-primary">Email Stats to Users</button>
    </form>
@endsection