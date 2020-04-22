@extends('layouts.app')

@section('content')
<div class="my-container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <note-list :filter="{{json_encode($filter)}}" :notes="{{json_encode($notes)}}" ></note-list>

        </div>
    </div>
</div>
@endsection

