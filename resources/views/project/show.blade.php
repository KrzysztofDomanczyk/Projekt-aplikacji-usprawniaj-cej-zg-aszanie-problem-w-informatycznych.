@extends('layouts.app')

@section('content')
<script type="application/javascript" src={{asset('js/project.js')}}>
                                        
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{$project->name}}</strong><a href="{{route('ticket.create')}}"
                        class="btn btn-success d-block mt-3">+ Add ticket</a>
                        
                    </div>
                       

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
                                    @if(Auth::id() == $project->creator->id)
                                    <form action="{{route('projects.destroy', ['project' => $project->id])}}" method="post">
                                        <input class="btn d-block w-100  mt-3 btn-outline-danger" type="submit" value="Delete" />
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}
                                    </form>
                                    @endif 
                                </div>
                            </div>
                            @if(Auth::id() == $project->creator->id)
                                <add-user :projectid="{{$project->id}}"></add-user>
                            @else 
                            <div class="card mt-4">
                                    <div class="card-body">
                                        <h5 class="card-title">Users: </h5>
                                        <ul class="list-group">
                                                @foreach($project->users as $user)
                                                <li class="list-group-item d-flex justify-content-between align-items-center" >
                                                    {{$user->email}}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </ul>
                                    </div>
                                </div>
                            
                            @endif
                            <div class="card mt-4">
                                <div class="card-body">
                                        @if(session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Created at</th>
                                                <th scope="col">Created by:</th>
                                                <th scope="col">Status:</th>
                                                <th scope="col">Operation:</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-break">
                                            @forelse ($project->tickets as $ticket)
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>{{$ticket->name}}</td>
                                                <td>{{$ticket->created_at}}</td>
                                                <td>{{$ticket->creator->email}}</td>
                                                <td>{{$ticket->status}}</td>
                                            <td class="d-flex"><a href="{{route('ticket.edit', ['ticket'=> $ticket->id, 'project' => $project->id])}}"><i class=" fas fa-edit"></i></a>
                                                    <form action="{{route('ticket.destroy', ['ticket' => $ticket->id])}}" method="post" style="display:content !important">
                                                    <input type="hidden" name="projectId" value="{{$project->id}}">
                                                    <input type="hidden" name="ticketId" value="{{$ticket->id}}">
                                                        <button type="submit" id="ticketDestroy" class="fabutton">
                                                            <i class=" ml-2 text-danger link fas fa-trash-alt"></i>
                                                      </button>
                                                        {!! method_field('delete') !!}
                                                        {!! csrf_field() !!}
                                                    </form>
                                                
                                                </td>
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
