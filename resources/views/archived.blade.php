@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <note-list :filter="{{json_encode(['archived' => true])}}"></note-list>

        </div>
    </div>
</div>
@endsection
