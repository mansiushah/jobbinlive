@extends('admin.layouts.form')



@section('title')

  {{ __('message.Change Password') }}

@endsection



@section('content')

      <div class="row">

        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>

         <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">

          <div class="container">

            <div class="row">

              <div class="col s10 m6 l6">

                <h5 class="breadcrumbs-title mt-0 mb-0"><span>{{ __('message.Change Password') }}</span></h5>

                <ol class="breadcrumbs mb-0">

                  <li class="breadcrumb-item"><a href="index.html">Home</a>

                  </li>

                  <li class="breadcrumb-item"><a href="#">Form</a>

                  </li>

                  <li class="breadcrumb-item active">{{ __('message.Change Password') }}

                  </li>

                </ol>

              </div>

            </div>

          </div>

        </div>

      <div class="col s12">

        <div class="container">

          <div class="section">

            <div class="row">

            <div class="col s12">

         <div id="validations" class="card card-tabs">

        <div class="card-content">

          <div class="card-title">

            <div class="row">

              <div class="col s12 m6 l10">

                <h4 class="card-title">{{ __('message.Change Password') }}</h4>

              </div>          

            </div>

          </div>


   @if(session()->has('success'))

                              <div class="alert alert-success">

                                  {{ session()->get('success') }}

                              </div>

                          @endif
          <div id="view-validations">

            <form class="formValidate" id="formValidate" method="post" action="{{ route('admin.changepassword') }}" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="id" value="{{ Auth::guard('admin')->user()->id }}">
              <div class="row">

                <div class="input-field col s12">

                  <label for="uname">{{ __('message.Current Password') }}*</label>

                  <input class=" form-control" id="uname" name="old_password" minlength="2" type="password" value="{{ old('old_password') }}" data-error=".errorTxt1" />

                  <small class="errorTxt1">@if($errors->has('old_password'))

                  <div class="error">{{ $errors->first('old_password') }}</div>

                  @endif</small>

                </div>

                  <div class="input-field col s12">

                  <label for="uname">{{ __('message.New Password') }}*</label>

                  <input class=" form-control" id="uname" name="new_password" minlength="2" type="password" value="{{ old('new_password') }}" data-error=".errorTxt1" />

                  <small class="errorTxt1">@if($errors->has('new_password'))

                  <div class="error">{{ $errors->first('new_password') }}</div>

                  @endif</small>

                </div>
                 <div class="input-field col s12">

                  <label for="uname">{{ __('message.Confirm Password') }}*</label>

                  <input class=" form-control" id="uname" name="con_password" minlength="2" type="password" value="{{ old('con_password') }}" data-error=".errorTxt1" />

                  <small class="errorTxt1">@if($errors->has('con_password'))

                  <div class="error">{{ $errors->first('con_password') }}</div>

                  @endif</small>

                </div>

               <div class="input-field col s12">

                  <button class="btn waves-effect waves-light right submit" type="submit" name="action">{{ __('message.Submit') }}

                    <i class="material-icons right">send</i>

                  </button>

                </div>

              </div>

            </form>

          </div>

          </div>

          </div>

         </div>

     </div>

  </div>

</div>

          <div class="content-overlay"></div>

        </div>

      </div>



 @endsection