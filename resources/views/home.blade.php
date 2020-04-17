@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            api token: {{ $token }}

            <div class="card mt-3">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('createNote') }}">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp" placeholder="enter title">
                        </div>
                        <div class="form-group">
                            <label for="text">Text</label>
                            <input type="text" name="text" class="form-control" id="text" placeholder="enter text">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            create note
                        </button>						
                    </form>
                </div>
            </div>


            <div class="card-columns">
                @foreach ($notes as $note)
                    <div class="card mt-3">
                        <div class="card-header">
                            {{ $note->title }}
                        </div>

                        <div class="card-body">
                            {{ $note->text }}
                            {{ $note->id }}

                            <div class="text-right inline-block">
                                <form method="POST" action="{{ route('deleteNote') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $note->id }}">
                                    <button class="btn p-0" type="submit">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>						
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
