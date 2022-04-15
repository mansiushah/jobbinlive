@extends('admin.layouts.main')







@section('title')



	{{ __('message.Dashboard')}}



@endsection







@section('content')







                        <!-- card stats start -->



                        <div id="card-stats" class="pt-0">



                            <div class="row">



                                <div class="col s12 m6 l3">



                                    <a href="#"><div class="card animate fadeLeft">



                                        <div class="card-content cyan white-text">



                                            <p class="card-stats-title"><i class="material-icons">person_outline</i>{{ __('message.Restaurant')}}</p>



                                            <h4 class="card-stats-number white-text">0000</h4>



                                            <p class="card-stats-compare">



                                                <i class="material-icons"></i> 



                                                <span class="cyan text text-lighten-5"></span>



                                            </p>



                                        </div>



                                        <div class="card-action cyan darken-1">



                                            <div id="clients-bar" class="center-align"></div>



                                        </div>



                                    </div></a>



                                </div>



                                <div class="col s12 m6 l3">



                                   <a href="#"> <div class="card animate fadeLeft">



                                        <div class="card-content red accent-2 white-text">



                                            <p class="card-stats-title"><i class="material-icons">attach_money</i>{{ __('message.Driver')}}</p>



                                            <h4 class="card-stats-number white-text">0000</h4>



                                            <p class="card-stats-compare">



                                                <i class="material-icons"></i>  <span class="red-text text-lighten-5"></span>



                                            </p>



                                        </div>



                                        <div class="card-action red">



                                            <div id="sales-compositebar" class="center-align"></div>



                                        </div>



                                    </div></a>



                                </div>



                                <div class="col s12 m6 l3">



                                   <a href="#"> <div class="card animate fadeRight">



                                        <div class="card-content orange lighten-1 white-text">



                                            <p class="card-stats-title"><i class="material-icons">trending_up</i>{{ __('message.User')}}</p>



                                            <h4 class="card-stats-number white-text">{{$user}}</h4>



                                            <p class="card-stats-compare">



                                                <i class="material-icons"></i>



                                                <span class="orange-text text-lighten-5"></span>



                                            </p>



                                        </div>



                                        <div class="card-action orange">



                                            <div id="profit-tristate" class="center-align"></div>



                                        </div>



                                    </div></a>



                                </div>



                                



                            </div>



                        </div>



                        <!--card stats end-->



                        <!--chart dashboard start-->



                       



                        <!--card widgets end-->



                    



                <div class="content-overlay"></div>



           



@endsection