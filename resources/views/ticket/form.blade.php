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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create ticket') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                <form action="{{route('ticket.store')}}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project_id" class="form-control" id="project">
                                @foreach($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Subject mail</label>
                            <input type="text" class="form-control" name="subject_mail" value="{{$email->getSubject()}}"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
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
                                        <input type="hidden" value="{{$email->getBody()}}" name="body_mail">
                                            <iframe src=" {{$email->getUrlBodyContent()}}" frameborder="0" class="w-100"
                                                style="height:400px"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Ticket name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                        aria-describedby="emailHelp" value="Ticket name Number {{$email->getUid()}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="text" class="form-control" name="description" id="exampleInputEmail1"
                                aria-describedby="emailHelp" value="Ticket descripiton Number {{$email->getUid()}}">
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="startDate">Start date</label>
                                    <input type="text" class="form-control" id="startDate" name="start_date" value="2020-09-11" placeholder="yyyy-mm-dd"></p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="endDate">End date</label>
                                    <input type="text" class="form-control" id="endDate" name="end_date" value="2020-11-11" placeholder="yyyy-mm-dd"></p>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" name="status" id="exampleFormControlSelect1">
                                <option>To do</option>
                                <option>In progress</option>
                                <option>Completed</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
