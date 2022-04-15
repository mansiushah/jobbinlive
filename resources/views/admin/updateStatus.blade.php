@extends('admin.layouts.form')

@section('title')
  Subscription
@endsection

@section('content')
      <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
         <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s10 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Status Update</span></h5>
                <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Form</a>
                  </li>
                  <li class="breadcrumb-item active">Status Update
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
                <h4 class="card-title">Status update</h4>
              </div>          
            </div>
          </div>
              @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif
     <div id="view-validations">
                                    <form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="{{ url('admin/changestatus', $data->id) }}" enctype="multipart/form-data">
                                       @csrf
                                      <div class="form-group ">
                                          <label for="cname" class="control-label col-lg-2">Status</label>
                                          <div class="col-lg-10">
                                             <select name="status" class="form-control m-bot15">
                                              <option value="0">Select Status</option>
                                              <option value="2" <?php if($data->status == '2') { echo "selected";} ?>>Block</option>
                                              <option value="1" <?php if($data->status == '1') { echo "selected";} ?>>Active</option>                                               
                                          </select>
                                          </div>
                                      </div>
                                      
                                     
                                      
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">

                                              <button class="btn btn-danger" type="submit">Save</button>
                                             <!--  <button class="btn btn-default" type="button">Cancel</button> -->
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