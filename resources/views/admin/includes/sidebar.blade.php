 <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark gradient-45deg-deep-purple-blue sidenav-gradient sidenav-active-rounded">



        <div class="brand-sidebar">



            <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="index.html"><img class="hide-on-med-and-down " src="{{ url('/public/app-assets/images/logo/logo.png') }}" alt="materialize logo" /><img class="show-on-medium-and-down hide-on-med-and-up" src="{{ url('/public/app-assets/images/logo/logo.png')}}" alt="materialize logo" /><!-- <span class="logo-text hide-on-med-and-down">Caffeto</span> --></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>



        </div>



        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">



            <li class="active bold"><a class="collapsible-header waves-effect waves-cyan " href="{{ url('/admin') }}"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">{{ __('Dashboard') }}</span></a>



               



            </li>



            <li class="navigation-header">



              <a class="navigation-header-text">Pages</a>



               <i class="navigation-header-icon material-icons">more_horiz</i>



        </li>



            <li class="bold">



              <a class="waves-effect waves-cyan " href="{{route('admin.user')}}"><i class="material-icons">perm_identity</i>



              <span class="menu-title" data-i18n="Mail">{{ __('User List') }}</span>



              </a>



        </li>







        

        

<li class="bold {{ Request::segment(2)=='skills' ? 'active open' : '' }}">

               <a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)">

               <i class="material-icons">school</i>

               <span class="menu-title" data-i18n="Invoice">{{ __('Skills') }}</span>

               </a>

                <div class="collapsible-body">

                  <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                  <li>

                    <a href="{{route('skills.index')}}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice List">{{ __('Skills') }}</span>

                    </a>

                  </li>

                  <li>

                    <a href="{{ route('skills.create') }}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice Add">{{ __('Add New') }}</span>

                    </a>

                  </li>

                </ul>

              </div>

        </li>
<li class="bold {{ Request::segment(2)=='preference' ? 'active open' : '' }}">

               <a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)">

               <i class="material-icons">school</i>

               <span class="menu-title" data-i18n="Invoice">{{ __('Preference') }}</span>

               </a>

                <div class="collapsible-body">

                  <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                  <li>

                    <a href="{{route('preference.index')}}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice List">{{ __('Preference') }}</span>

                    </a>

                  </li>

                  <li>

                    <a href="{{ route('preference.create') }}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice Add">{{ __('Add New') }}</span>

                    </a>

                  </li>

                </ul>

              </div>

        </li>
<li class="bold {{ Request::segment(2)=='education' ? 'active open' : '' }}">

               <a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)">

               <i class="material-icons">school</i>

               <span class="menu-title" data-i18n="Invoice">{{ __('Education') }}</span>

               </a>

                <div class="collapsible-body">

                  <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                  <li>

                    <a href="{{route('education.index')}}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice List">{{ __('Education') }}</span>

                    </a>

                  </li>

                  <li>

                    <a href="{{ route('education.create') }}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice Add">{{ __('Add New') }}</span>

                    </a>

                  </li>

                </ul>

              </div>

        </li>
         
<li class="bold {{ Request::segment(2)=='subscription' ? 'active open' : '' }}">

               <a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)">

               <i class="material-icons">school</i>

               <span class="menu-title" data-i18n="Invoice">{{ __('Subscripcation') }}</span>

               </a>

                <div class="collapsible-body">

                  <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                  <li>

                    <a href="{{route('subscription.index')}}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice List">{{ __('Subscripcation') }}</span>

                    </a>

                  </li>

                  <li>

                    <a href="{{ route('subscription.create') }}" ><i class="material-icons">radio_button_unchecked</i><span data-i18n="Invoice Add">{{ __('Add New') }}</span>

                    </a>

                  </li>

                </ul>

              </div>

        </li>
        

        </ul>



        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>



    </aside>