@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('New project') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{route('projects.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" value="Projekt IT"
                                    id="name" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" name="description" value="Jakiś opis"
                                    id="description" aria-describedby="emailHelp">
                            </div>
                            <input type="hidden" name="redirect" value="{{$redirect}}">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
