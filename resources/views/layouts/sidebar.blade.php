<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading" style="width:230px !important">
        <img src="{{asset('images/logo.jpeg')}}" style="width:100%">
        <img src="{{asset('images/logo-1.jpg')}}" style="width:40%">
    </div>
    <div class="list-group list-group-flush">       
        <div class="sidebar sidebar-light"> 
        <ul class="list-unstyled">
            <li class="{{  strpos(Route::currentRouteName(),'dashboard') !== false ? 'active' : '' }}">
                <a href="{{route('dashboard')}}" class="">
                    <i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            @if(Auth::user()->role == 1)
                <li class="{{  strpos(Route::currentRouteName(),'settings') !== false ? 'active' : '' }}">
                    <a href="{{route('settings')}}" class="">
                        <i class="fas fa-list-alt"></i> Settings</a>
                </li> 
                <li class="{{  strpos(Route::currentRouteName(),'categories') !== false ? 'active' : '' }}">
                    <a href="{{route('categories.index')}}" class="">
                        <i class="fas fa-list-alt"></i> Category</a>
                </li> 
                <li>
                    <a class="nav-link" data-toggle="collapse" href="#countries-layouts-requests"
                        aria-expanded="{{ strpos(Route::currentRouteName(), 'detail_estimate') !== false ? 'false' : '' }}              
                   {{ strpos(Route::currentRouteName(), 'approx_estimate') !== false ? 'false' : '' }}"
                        aria-controls="countries-layouts-requests">
                        <i class="fas fa-globe"></i> Countries
                    </a>
                    <div class="collapse non-padding {{ strpos(Route::currentRouteName(), 'detail_estimate') !== false ? 'show' : '' }}             
                {{ strpos(Route::currentRouteName(), 'approx_estimate') !== false ? 'show' : '' }}"
                        id="countries-layouts-requests">
                        <ul class="list-unstyled">
                            <li
                                class="{{ strpos(Route::currentRouteName(), 'detail_estimate') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{ route('detail_estimate.index') }}">
                                    <i class="fas fa-info-circle"></i> Detail Estimate
                                </a>
                            </li>
                            <li
                                class="{{ strpos(Route::currentRouteName(), 'approx_estimate') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{ route('approx_estimate.index') }}">
                                    <i class="fas fa-calendar-alt"></i> Approx Estimate
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                                       
                <li>
                    <a class="nav-link"  data-toggle="collapse" href="#main-entries-layouts-requests" 
                    aria-expanded="{{strpos(Route::currentRouteName(),'low_concrete') !== false ?'false':''}}              
                    {{strpos(Route::currentRouteName(),'high_concrete') !== false ?'false':''}}
                    {{strpos(Route::currentRouteName(),'high_commercial') !== false ?'false':''}}
                    {{strpos(Route::currentRouteName(),'low_commercial') !== false ?'false':''}}
                    {{strpos(Route::currentRouteName(),'ware_house') !== false ?'false':''}}" 
                    aria-controls="main-entries-layouts-requests"> 
                    <i class="fas fa-folder"></i> Approx Main Entries</a>
                    <div class="collapse non-padding {{strpos(Route::currentRouteName(),'low_concrete') !== false ?'show':''}}             
                    {{strpos(Route::currentRouteName(),'high_concrete') !== false ?'show':''}}
                    {{strpos(Route::currentRouteName(),'high_commercial') !== false ?'show':''}}
                    {{strpos(Route::currentRouteName(),'low_commercial') !== false ?'show':''}}
                    {{strpos(Route::currentRouteName(),'ware_house') !== false ?'show':''}}" id="main-entries-layouts-requests">
                        <ul class="list-unstyled">

                            <!-- <li class="{{  strpos(Route::currentRouteName(),'low_concrete') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{route('low_concrete.index')}}">
                                    <i class="fas fa-file"></i> Building Low End Concrete Dwelling</a>
                            </li>

                            <li class="{{  strpos(Route::currentRouteName(),'high_concrete') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{route('high_concrete.index')}}">
                                    <i class="fas fa-file"></i> Building High End Concrete Dwelling</a>
                            </li>

                            <li class="{{  strpos(Route::currentRouteName(),'low_commercial') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{route('low_commercial.index')}}">
                                    <i class="fas fa-file"></i> Building Low End Commercial Offices</a>
                            </li>

                            <li class="{{  strpos(Route::currentRouteName(),'high_commercial') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{route('high_commercial.index')}}">
                                    <i class="fas fa-file"></i> Building High End Commercial Offices</a>
                            </li>

                            <li class="{{  strpos(Route::currentRouteName(),'ware_house') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{route('ware_house.index')}}">
                                    <i class="fas fa-file"></i> Building Ware House</a>
                            </li> -->
                            <?php $menus = getMenus(); 
                                foreach($menus as $menu)
                                { ?>
                                    <li class="{{  strpos(Route::currentRouteName(),$menu->url) !== false ? 'active' : '' }}">
                                        <a class="submenu" href="{{route($menu->url.'.index')}}">
                                        <i class="fas fa-file"></i> Building {{$menu->menu_name}}</a>
                                    </li>
                            <?php }
                            ?>
                            <li class="{{  strpos(Route::currentRouteName(),'add-menu') !== false ? 'active' : '' }}">
                                <a class="submenu" href="{{route('add-menu')}}">
                                    <i class="fas fa-plus"></i> Add</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="{{  strpos(Route::currentRouteName(),'job_activities') !== false ? 'active' : '' }}">
                    <a href="{{route('job_activities.index')}}" class="">
                        <i class="fas fa-address-card"></i> Job Activities</a>
                </li>
                <!-- <li class="{{ strpos(Route::currentRouteName(),'resource_components') !== false ? 'active' : '' }}">
                    <a href="{{route('resource_components.index')}}" class="">
                        <i class="fas fa-address-card"></i> Resource Components</a>
                </li> -->

                <li>
                    <a class="nav-link"  data-toggle="collapse" href="#country" 
                    aria-expanded="{{strpos(Route::currentRouteName(),'resource_components') !== false ?'false':''}}" 
                    aria-controls="country"> 
                    <i class="fas fa-folder"></i> Resource Components</a>
                    <div class="collapse non-padding {{strpos(Route::currentRouteName(),'resource_components') !== false ?'show':''}}" id="country">
                        <ul class="list-unstyled">
                            <?php 
                                $param1 = \Request::segment(1); 
                                $param = \Request::segment(3);
                            ?>
                            <li class="<?php if(!empty($param1) && $param1 == 'resource_components' && empty($param)) echo 'active' ?>">
                                <a class="submenu" href="{{route('resource_components.index')}}">
                                <i class="fas fa-file"></i> Master Resource Components</a>
                            </li>
                            <?php $countrys = getCountrys();                             
                            // echo '<pre>'; print_r($param);
                                foreach($countrys as $country)
                                { ?>
                                    <li class="<?php if(!empty($param) && $param == base64_encode($country->id)) echo 'active'; ?>">
                                        <a class="submenu" href="{{route('resource_components.country', base64_encode($country->id))}}">
                                        <i class="fas fa-file"></i> {{$country->country_name}}</a>
                                    </li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </li>
            @endif
            <li class="{{  strpos(Route::currentRouteName(),'cost-estimate.form') !== false ? 'active' : '' }}">
                <a href="{{route('cost-estimate.form')}}" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Approx Estimate Form</a>                    
            </li>
            <li class="{{  strpos(Route::currentRouteName(),'detail-estimate.form') !== false ? 'active' : '' }}">
                <a href="{{route('detail-estimate.form')}}" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Detail Estimate Form</a>                    
            </li>
            <li class="{{  strpos(Route::currentRouteName(),'approx_form_list') !== false ? 'active' : '' }}">
                <a href="{{route('approx_form_list')}}" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Approx Estimate Saved List</a>                    
            </li>
            <li class="{{  strpos(Route::currentRouteName(),'detail_form_list') !== false ? 'active' : '' }}">
                <a href="{{route('detail_form_list')}}" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Detail Estimate Saved List</a>                    
            </li>
            <li class="{{  strpos(Route::currentRouteName(),'demo') !== false ? 'active' : '' }}">
                <a href="{{route('demo')}}" class="">
                    <i class="fas fa-file"></i> Demo</a>                    
            </li>
        </ul> 
        </div>   
    </div>
</div>
 