@extends('admin.layouts.form')



@section('title')

  Driver

@endsection



@section('content')

      <div class="row">

        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>

        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">

          <div class="container">

            <div class="row">

              <div class="col s10 m6 l6">

                <h5 class="breadcrumbs-title mt-0 mb-0"><span>List Driver</span></h5>

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

                        <h4 class="card-title">Driver</h4>

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

                                  <th>Name</th>

                                  <th>Email</th>

                                  <th>Mobile</th>

                                   <th>Status</th>

                                  <th>Action</th>

                                </tr>

                              </thead>

                              <tbody>

                                 <?php $i=1; ?>

                                  @foreach($data as $row)

                                <tr>

                                   <td>{{$i++}}</td>

                                 <td><a href="{{ route('admin.driverviews', $row->id) }}">{{ $row->name }}</a></td>

                                  <td>{{ $row->email }}</td>

                                  <td>{{ $row->phone }}</td>

                                  <td><?php if($row->status == '1') { ?><span class=" users-view-status chip green lighten-5 green-text">Active</span>

                              <?php } else { ?> <span class=" users-view-status chip red lighten-5 red-text">Block</span><?php } ?></td>

                                  <td>

                                   <a href="{{URL::to('/admin/changestatus/' . $row->id)}}" class="btn btn-primary">Update Status</a>

                                 </td>

                                </tr>

                                 @endforeach

                              </tbody>

                              <tfoot>

                                <tr>

                                <th>No</th>

                                  <th>Name</th>

                                  <th>Email</th>

                                  <th>Mobile</th>

                                   <th>Status</th>

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