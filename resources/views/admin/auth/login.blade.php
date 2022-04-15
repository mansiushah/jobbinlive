@extends('admin.layouts.auth')



@section('content')



                    <form method="POST" action="{{ route('adminLoginPost') }}">

                        <div class="row">

                                <div class="input-field col s12">

                                    <h5 class="ml-4">{{ __('Admin Login') }}</h5>

                                </div>

                            </div>

                        @csrf

                        <div class="row margin">

                                <div class="input-field col s12">

                                    <i class="material-icons prefix pt-2">person_outline</i>

                                    <input id="username" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                     @if ($errors->has('email'))

                                    <span class="invalid-feedback">

                                        <strong>{{ $errors->first('email') }}</strong>

                                    </span>

                                @endif

                                    <label for="username" class="center-align">{{ __('UserName') }}</label>

                                </div>

                            </div>

                            <div class="row margin">

                                <div class="input-field col s12">

                                    <i class="material-icons prefix pt-2">lock_outline</i>

                                    <input id="password"  type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                      @if ($errors->has('password'))

                                    <span class="invalid-feedback">

                                        <strong>{{ $errors->first('password') }}</strong>

                                    </span>

                                @endif

                                    <label for="password">{{ __('Password') }}</label>

                                </div>

                            </div>

                        



                        

<!-- 

                        <div class="form-group row mb-0">

                            <div class="col-md-8 offset-md-4">

                                <button type="submit" class="btn btn-primary">

                                    {{ __('Login') }}

                                </button>



                                <a class="btn btn-link" href="{{ route('password.request') }}">

                                    {{ __('Forgot Your Password?') }}

                                </a>

                            </div>

                        </div> -->

                        <div class="row">

                                <div class="input-field col s12">

                                   <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">{{ __('message.Login') }}</button>

                                </div>

                            </div>

                            <div class="row">

                                <div class="input-field col s6 m6 l6">

                                    <p class="margin medium-small"><!-- <a href="user-register.html">Register Now!</a> --></p>

                                </div>

                                <div class="input-field col s6 m6 l6">

                                  <!--   <p class="margin right-align medium-small"><a href="{{ route('password.request') }}">Forgot password ?</a></p> -->

                                </div>

                            </div>

                    </form>

                

@endsection