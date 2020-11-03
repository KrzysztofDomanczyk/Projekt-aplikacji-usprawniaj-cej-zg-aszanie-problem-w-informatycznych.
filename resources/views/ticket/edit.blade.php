@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="application/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="application/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
{{-- <script type="application/javascript">
    $(document).ready(function() {
        $('#startDate').datepicker();
    });
</script> --}}
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Edit ticket') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{route('ticket.update', ['ticket' => $ticket->id])}}" method="post">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="project">Project </label>

                            <select name="project_id" class="form-control" id="project">
                                @foreach($projects as $project)

                                @if($project->id == $ticket->project_id)
                                <option value="{{$project->id}}" selected>{{$project->name}}</option>
                                @else
                                <option value="{{$project->id}}">{{$project->name}}</option>
                                @endif
                                @endforeach
                            </select>

                            @if(isset($email))
                            <a href="{{route('projects.create', ['redirect' => $email->getUid() ])}}"
                                class="btn btn-secondary d-block mt-3">+ Project not exist? Create new!</a>
                            @else
                            <a href="{{route('projects.create')}}" class="btn btn-secondary d-block mt-3">+ Project not
                                exist? Create new!</a>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Subject mail</label>

                            <input type="text" class="form-control" name="subject_mail"
                                value="{{$ticket->subject_mail}}" id="exampleInputEmail1" aria-describedby="emailHelp">

                        </div>

                        <div class="form-group">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            See body mail:
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <iframe src=" {{$ticket->getUrlBody()}}" frameborder="0" class="w-100"
                                                style="height:400px"></iframe>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Ticket name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                aria-describedby="emailHelp" value="{{$ticket->name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="text" class="form-control" name="description" id="exampleInputEmail1"
                                aria-describedby="emailHelp" value="{{$ticket->description}}">
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="startDate">Start date</label>
                                    <input type="text" class="form-control" id="startDate" name="start_date"
                                        value="{{$ticket->start_date}}" placeholder="yyyy-mm-dd"></p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="endDate">End date</label>
                                    <input type="text" class="form-control" id="endDate" name="end_date"
                                        value="{{$ticket->end_date}}" placeholder="yyyy-mm-dd"></p>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" name="status" id="exampleFormControlSelect1">
                                <option @if($ticket->status == "To do") selected @endif>To do</option>
                                <option @if($ticket->status == "In progress") selected @endif>In progress</option>
                                <option @if($ticket->status == "Completed") selected @endif>Completed</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
                @include('ticket.comments')
        </div>
    </div>
    @endsection
