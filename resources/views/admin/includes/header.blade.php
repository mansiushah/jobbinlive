    <header class="page-topbar" id="header">



        <div class="navbar navbar-fixed">



            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-light">



                <div class="nav-wrapper">



                    <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>



                        <input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Explore Materialize" data-search="template-list">



                        <ul class="search-list collection display-none"></ul>



                    </div>



                    <ul class="navbar-list right">



                        



                        



                        <li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>



                              <!-- <li class="dropdown-item"><a class="grey-text text-darken-1" href="{{ url('lang/en') }}" data-language="en"><i class="flag-icon flag-icon-gb"></i> {{ __('message.English')}}</a></li>

                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="{{ url('lang/es') }}" data-language="es"><i class="flag-icon flag-icon-es"></i> {{ __('message.Spanish')}}</a></li> -->

                        <li class="dropdown-language"><a class="waves-effect waves-block waves-light translation-button" href="#" data-target="translation-dropdown"><span class="flag-icon @if(app()->getLocale() == 'en') flag-icon-gb @elseif(app()->getLocale() == 'es')flag-icon-es  flag-icon-ad @endif"></span></a></li>



                        <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{ url('/public/app-assets/images/avatar/avatar-7.png')}}" alt="avatar"><i></i></span></a></li>



                        



                    </ul>



                    <!-- translation-button-->



                    <ul class="dropdown-content" id="translation-dropdown">

                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="{{ url('lang/en') }}" data-language="en"><i class="flag-icon flag-icon-gb"></i> {{ __('message.English')}}</a></li>

                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="{{ url('lang/es') }}" data-language="es"><i class="flag-icon flag-icon-es"></i> {{ __('message.Spanish')}}</a></li>

                        

                    </ul>



                    <!-- notifications-dropdown-->



                    <!-- translation-button-->

                    <ul class="dropdown-content" id="translation-dropdown">

                 

                   

                    </ul>





                    <!-- profile-dropdown-->



                    <ul class="dropdown-content" id="profile-dropdown">



                        <li><a class="grey-text text-darken-1" href="{{ route('admin.profile') }}"><i class="material-icons">person_outline</i> {{ __('message.My Profile')}}</a></li>

                        <li><a class="grey-text text-darken-1" href="{{ route('admin.editchangepassword') }}"><i class="material-icons">person_outline</i>{{ __('message.Change Password')}}</a></li>



                        <li>

            <a class="grey-text text-darken-1" href="{{ route('adminLogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">



              <i class="fa fa-key"></i> {{ __('message.Logout')}}



            </a>



            <form id="logout-form" action="{{ route('adminLogout') }}" method="POST" style="display: none;">



              @csrf



            </form>



          </li>



                    </ul>



                </div>



                <nav class="display-none search-sm">



                    <div class="nav-wrapper">



                        <form id="navbarForm">



                            <div class="input-field search-input-sm">



                                <input class="search-box-sm mb-0" type="search" required="" id="search" placeholder="Explore Materialize" data-search="template-list">



                                <label class="label-icon" for="search"><i class="material-icons search-sm-icon">search</i></label><i class="material-icons search-sm-close">close</i>



                                <ul class="search-list collection search-list-sm display-none"></ul>



                            </div>



                        </form>



                    </div>



                </nav>



            </nav>



        </div>



    </header>