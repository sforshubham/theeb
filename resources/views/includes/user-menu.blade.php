							<a id="lang_switch_link" href="{{ URL::to('/') }}"><img src="{{ url('/') }}/images/log-icon.png" /> {{session()->has('user.IDNo') && session('user.FirstName') != '' ? session('user.FirstName') : 'User'}}</a>
                            <ul class="sub-menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ URL::to('/profile') }}">{{ __('Profile') }}</a></li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ URL::to('/book') }}">{{ __('Rent a car') }}</a></li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ URL::to('/tariff') }}">{{ __('Tariffs') }}</a></li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ URL::to('/booking') }}">{{ __('My Booking') }}</a></li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ URL::to('/agreement') }}">{{ __('Rental History') }}</a></li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ URL::to('/change_password') }}">{{ __('Change Password') }}</a></li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ URL::to('/logout') }}">{{ __('Logout') }}</a></li>
                            </ul>