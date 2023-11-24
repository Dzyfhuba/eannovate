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
    <form action="{{ isset($data) ? route('room.update', $data->id) : route('room.store') }}" method="POST"
        enctype="multipart/form-data">
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
            <select name="major" id="major" class="custom-select">
                <option value="" hidden>--- Select Major ----</option>
            </select>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    // fetch major from https://www.eannov8.com/career/case/getMajor.json add to select#major
    $.ajax({
        url: 'https://www.eannov8.com/career/case/getMajor.json',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var major = data.data;
            var html = '';
            for (var i = 0; i < major.length; i++) {
                html += '<option value="' + major[i].name + '">' + major[i].name + '</option>';
            }
            $('#major').html(html);
        }
    });
</script>
@endsection
