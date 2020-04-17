@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <note-list access_token="{{ Auth::User()->access_token }}"></note-list>

        </div>
    </div>
</div>
@endsection

