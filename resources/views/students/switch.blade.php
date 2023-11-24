@extends('layouts.app')

@section('style')
<style>
    .tab {
        display: grid;
        grid-template-columns: 50% 50%;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 12px;
    }
    .tab button {
        width: 100%;
        background-color: #b5b5b5;
        border-radius: 0px;
        font-weight: 700
    }
    .tab button:hover {
        text-decoration: underline;
    }
    .tab button:active {
        box-shadow: inset 0px 0px 12px 4px rgba(0, 0, 0, 0.2)
    }
</style>
@endsection

<!-- this page use to with betweet room and form -->
@section('content')
<div class="container">
    <h1>Student Form</h1>
    <div class="tab">
        <button class="btn" id="form-key">Form</button>
        <button class="btn" id="room-key">Class</button>
    </div>
    <div id='form'>
        @include('students.form')
    </div>
    <div id='room' class="d-none">
        @include('students.room')
    </div>
</div>
@endsection

@section('script')
<script>
    const form = document.querySelector('#form')
    const room = document.querySelector('#room')
    document.querySelector('#form-key').addEventListener('click', () => {
        form.classList.remove('d-none')
        room.classList.add('d-none')
    })
    document.querySelector('#room-key').addEventListener('click', () => {
        form.classList.add('d-none')
        room.classList.remove('d-none')
    })
</script>
@endsection
