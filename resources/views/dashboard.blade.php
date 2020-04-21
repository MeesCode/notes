@extends('layouts.app')

@section('content')
<div class="my-container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <note-list :filter="{{json_encode(['archived' => false])}}" ></note-list>

        </div>
    </div>
</div>
@endsection

