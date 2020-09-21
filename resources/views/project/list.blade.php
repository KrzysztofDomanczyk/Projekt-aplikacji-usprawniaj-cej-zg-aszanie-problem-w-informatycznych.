@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('My projects') }} <a href="{{route('projects.create')}}" class="btn btn-success d-block mt-3">+ Add project</a> </div>

                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
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
                                
                                @foreach($user->projects as $project)
                                <tr>
                                    <th scope="row">1</th>
                                <td><a href="{{route('projects.show', ['project' => $project->id])}}">{{$project->name}}</a></td>
                                    <td>{{$project->created_at}}</td>
                                    <td>{{$project->creator->email}}</td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
