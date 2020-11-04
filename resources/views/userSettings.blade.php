@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User settings') }}</div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{!! session()->get('error') !!}</li>
                            </ul>
                        </div>
                    @endif
                        <h5 class="card-title">IMAP settings<br></h5>
                        
                        
                    <form action="{{route('changeImap')}}" method="POST">
                            @csrf
                                <div class="form-group">
                                  <label for="host">*Host:</label>
                                <input type="text" class="form-control"  name="host_imap" id="host" aria-describedby="emailHelp" placeholder="imap.gmail.com" value="{{$user->host_imap}}">
                                </div>
                                
                                <div class="form-group">
                                  <label for="username">Username:</label>
                                  <input type="text" class="form-control" name="username_imap"  id="username" placeholder="ithelperdomanczyk@gmail.com" value="{{$user->username_imap}}">
                                </div>
                                <div class="form-group">
                                  <label for="password">Password:</label>
                                  <input type="password" class="form-control" name="password_imap"  id="password" placeholder="Krzysiek123456" value="{{$user->password_imap}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                              <small class="mt-3 d-block">*If you want use gmail, you have to set "Less secure apps" in gmail account settings.</small>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            Ustawienia użytkownika
                        </div>
                    @endif
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            Ustawienia użytkownika
                        </div>
                    @endif
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
