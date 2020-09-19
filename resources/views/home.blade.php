@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @role('developer')

                    Hello developer
                   
                   @endrole
                   @role('manager')

                    Hello manager

                    @endrole
                

                    <div id="accordion">
                        @foreach($emails as $email)
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <a class="btn w-100" data-toggle="collapse" data-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapseOne">
                                 <div class="row">
                                        <div class="col-12 col-md-8">
                                                <strong>Subject:</strong> {!!$email->getSubject()!!}  
                                                <div><strong>From:</strong> {!!$email->getNameFrom()!!} <br></div> 
                                                <div>
                                                        <small>{{$email->getDate()->toString()}}</small>
                                                </div>
                                        </div>
                                        <div  class="col-12 col-md-6">
                                              
                                        </div>
                                 </div>
                              </a>
                            </h5>
                          </div>
                      
                          <div id="collapse{{$loop->index}}" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                    {!!$email->getBody()!!}
                            </div>
                          </div>
                        </div>
                        @endforeach

                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
