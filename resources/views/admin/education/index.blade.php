@extends('admin.layouts.form')







@section('title')



  Dashboard



@endsection







@section('content')



      <div class="row">



        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>



        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">



          <div class="container">



            <div class="row">



              <div class="col s10 m6 l6">



                <h5 class="breadcrumbs-title mt-0 mb-0"><span>List Category</span></h5>



                <ol class="breadcrumbs mb-0">



                  <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a>



                  </li>



                  <li class="breadcrumb-item"><a href="#">Table</a>



                  </li>



                  <li class="breadcrumb-item active">DataTable



                  </li>



                </ol>



              </div>



             



            </div>



          </div>



        </div>



        <div class="col s12">



          <div class="container">



            <div class="section section-data-tables">



                <div class="row">



                  <div class="col s12">



                    <div class="card">



                      <div class="card-content">



                        <h4 class="card-title">Category</h4>



                        @if(session()->has('success'))



                              <div class="alert alert-success">



                                  {{ session()->get('success') }}



                              </div>



                          @endif



                           



                        <div class="row">



                          <div class="col s12">



                            <table id="page-length-option" class="display">



                              <thead>



                                <tr>



                                  <th>No</th>
                                  <th>Title</th>

                                  <th>Action</th>



                                </tr>



                              </thead>



                              <tbody>



                                 <?php $i=1; ?>



                                  @foreach($data as $row)



                                <tr>



                                  <td>{{$i++}}</td>



                                  <td>{{ $row->title }}</td>



                                  <td>


                <form action="{{ route('education.destroy',$row->id) }}" method="POST">

                                  <a href="{{ route('education.edit', $row->id) }}" class="btn-small indigo">Edit</a>



                                  @csrf
                    @method('DELETE')



                                 
 <button type="submit" class="btn btn-danger">Delete</button>
                </form>

                              </td>



                                  



                                </tr>



                                 @endforeach



                              </tbody>



                              <tfoot>



                                <tr>



                                 <th>No</th>



                                  <th>Image</th>



                                  <th>Title</th>



                                 



                                  <th>Action</th>



                                </tr>



                              </tfoot>



                            </table>



                          </div>



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