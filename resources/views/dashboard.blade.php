@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <create-note></create-note>
            <note-list filter="allNotes"></note-list>

        </div>
    </div>
</div>
@endsection

