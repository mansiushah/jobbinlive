@extends('admin.layouts.form')







@section('title')



  Preference



@endsection







@section('content')



      <div class="row">



        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>



         <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">



          <div class="container">



            <div class="row">



              <div class="col s10 m6 l6">



                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Preference</span></h5>



                <ol class="breadcrumbs mb-0">



                  <li class="breadcrumb-item"><a href="#">Home</a>



                  </li>



                  <li class="breadcrumb-item"><a href="#">Form</a>



                  </li>



                  <li class="breadcrumb-item active">Preference



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



                <h4 class="card-title">Preference</h4>



              </div>          



            </div>



          </div>







          <div id="view-validations">



            <form class="formValidate" id="formValidate" method="post" action="{{ route('preference.store') }}" enctype="multipart/form-data">



                @csrf



              <div class="row">



                <div class="input-field col s12">



                  <label for="uname">Title*</label>



                  <input class=" form-control" id="uname" name="title" minlength="2" type="text" value="{{ old('title') }}" data-error=".errorTxt1" />



                  <small class="errorTxt1">@if($errors->has('title'))



                  <div class="error">{{ $errors->first('title') }}</div>



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



  