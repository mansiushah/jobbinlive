@extends('admin.layouts.form')

@section('title')
 Edit Profile
@endsection

@section('content')
      <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
         <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s10 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Profile</span></h5>
                <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Form</a>
                  </li>
                  <li class="breadcrumb-item active">Profile
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
                <h4 class="card-title">Profile Form list</h4>
                  @if(session()->has('success'))
                              <div class="alert alert-success">
                                  {{ session()->get('success') }}
                              </div>
                          @endif
              </div>          
            </div>
          </div>

          <div id="view-validations">
            <form class="formValidate" id="formValidate" method="post" action="{{ url('admin/profile') }}" enctype="multipart/form-data">
                   @csrf
                                         @method('POST')
                                         <input type="hidden" name="id" value="{{$data->id}}">
              <div class="row">
                <div class="input-field col s12">
                  <label for="uname">Name*</label>
                  <input class=" form-control" id="uname" name="name" minlength="2" type="text" value="{{ $data->name }}" data-error=".errorTxt1" />
                  <small class="errorTxt1">@if($errors->has('name'))
                  <div class="error">{{ $errors->first('name') }}</div>
                  @endif</small>
                </div>
                 
                
                <div class="input-field col s12">
                  <button class="btn waves-effect waves-light right submit" type="submit" name="action">Submit
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
