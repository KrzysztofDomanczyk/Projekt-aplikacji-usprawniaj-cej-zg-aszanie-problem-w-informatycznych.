@extends('layouts.app')

@section('content')
<script type="application/javascript" src={{asset('js/project.js')}}>
                                        
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{$project->name}}</strong><a href="{{route('projects.create')}}"
                        class="btn btn-success d-block mt-3">+ Add ticket</a></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Description: </h5>
                                    <p class="card-text">{{$project->description}}</p>
                                    <footer class="blockquote-footer">Created by:
                                        <strong>{{$project->creator->email}}</strong></footer>
                                    <footer class="blockquote-footer">Created at: {{$project->created_at}}</footer>
                                </div>
                            </div>
                            <add-user :projectid="{{$project->id}}"></add-user>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Created at</th>
                                                <th scope="col">Created by:</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @forelse ($project->tickets as $ticket)
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>{{$ticket->name}}</td>
                                                <td>{{$ticket->created_at}}
                                                <td>
                                                <td>{{$ticket->creator->email}}</td>
                                            </tr>
                                            @empty
                                            <nav aria-label="breadcrumb">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item active" aria-current="page">No tickets
                                                    </li>
                                                </ol>
                                            </nav>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
