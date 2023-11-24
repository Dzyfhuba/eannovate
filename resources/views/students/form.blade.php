@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
            @csrf()
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username..." required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email..." required>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control" name="age" id="age" placeholder="Age..." required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="Phone number..." required>
            </div>
            <div class="form-group">
                <label for="picture">Picture</label>
                <input type="file" class="form-control-file" name="picture" id="picture" placeholder="Picture..." required>
            </div>
        </form>
    </div>
@endsection
