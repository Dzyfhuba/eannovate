@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ isset($data) ? route('room.update', $data->id) : route('room.store') }}" method="POST" enctype="multipart/form-data">
            @csrf()
            @if (isset($data))
                @method('PUT')
            @endif
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name..." required
                    value="{{ isset($data) ? $data->name : '' }}">
            </div>
            <div class="form-group">
                <label for="major">Major</label>
                <input type="text" class="form-control" name="major" id="major" placeholder="Email..." required
                    value="{{ isset($data) ? $data->major : '' }}">
            </div>
        </form>
    </div>
@endsection
