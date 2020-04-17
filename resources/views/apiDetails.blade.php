@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">api token</div>

                <div class="card-body">
                    {{ Auth::user()->access_token }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
