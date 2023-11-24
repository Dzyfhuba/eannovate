@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="text-right mb-3">
    <a href="{{ route('student.create') }}" class="btn btn-primary">New Student</a>
  </div>
  <table id="myTable" class="table-responsive">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Age</th>
            <th>Phone Number</th>
            <th>Picture</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $s)
            <tr>
                <td>{{$s->username}}</td>
                <td>{{$s->email}}</td>
                <td>{{$s->age}}</td>
                <td>{{$s->phone_number}}</td>
                <td>{{$s->picture}}</td>
                <td>{{$s->created_by}}</td>
                <td>{{$s->updated_by}}</td>
                <td>{{$s->created_at}}</td>
                <td>{{$s->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
  </table>
  {{-- {{$students->links()}} --}}
</div>
@endsection
