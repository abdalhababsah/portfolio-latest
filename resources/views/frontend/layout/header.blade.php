<header class="stick" id="stickyHeader">
    <div class="logo-menu-wrapper position-relative w-100">
        <div class="container">
            <div class="logo-menu-inner d-flex gap-4 align-items-center justify-content-between position-relative w-100">
                <div class="logo">
                    <h1>
                        <a href="{{ route('home') }}" title="{{ __('Home') }}">
                            <img class="scheme1-light-logo" src="{{ asset('frontend/assets/images/pngfind.com-ideas-png-1439026.png') }}" alt="{{ __('Logo') }}" loading="lazy">
                            <!-- Other logo images remain unchanged -->
                        </a>
                    </h1>
                </div><!-- Logo -->

                <nav>
                    <a class="res-menu-close" href="javascript:void(0);" title=""><i class="fal fa-times"></i></a>
                    <ul>
                        <li><a href="{{ route('home') }}" title="">{{ __('Home') }}</a></li>
                        <li><a href="{{ route('home') }}#projects" title="{{ __('Projects Section') }}">{{ __('Projects') }}</a></li>
                        <li><a href="{{ route('home') }}#services" title="{{ __('Services Section') }}">{{ __('Services') }}</a></li>
                        <li><a href="{{ route('home') }}#contact" title="">{{ __('Contact') }}</a></li>
                        
                        <!-- Mobile-only language switcher -->
                        <li id="displayNone" class="mobile-menu-lang">
                            <a href="{{ route('locale.switch', app()->getLocale() == 'en' ? 'ar' : 'en') }}">
                                <i class="far fa-globe"></i>
                                <span>{{ app()->getLocale() == 'en' ? __('العربية') : __('English') }}</span>
                            </a>
                        </li>
                        
                        <!-- Mobile-only email -->
                        <li id="displayNone" class="mobile-menu-email">
                            <a href="mailto:user@yoursite.com">
                                <i class="far fa-envelope"></i>
                                <span>user@yoursite.com</span>
                            </a>
                        </li>
                        
                        <!-- Mobile-only contact button -->
                        <li id="displayNone" class="mobile-menu-cta">
                            <a href="javascript:void(0);">
                                <span>{{ __('LETS TALK') }}</span>
                                <i class="far {{ app()->getLocale() == 'ar' ? 'fa-long-arrow-left' : 'fa-long-arrow-right' }}"></i>
                            </a>
                        </li>
                    </ul>
                </nav><!-- Navigation -->

                <a class="res-menu-btn" href="javascript:void(0);" title=""><i class="fal fa-align-center"></i></a>

                <div class="cont-links d-flex position-relative">
                    <div class="lang-switcher me-2">
                        <a href="{{ route('locale.switch', app()->getLocale() == 'en' ? 'ar' : 'en') }}" class="lang-btn">
                            {{ app()->getLocale() == 'en' ? __('العربية') : __('English') }}
                            <i class="far fa-globe ms-1"></i>
                        </a>
                    </div>
                    <a href="mailto:user@yoursite.com" title=""><i class="far fa-envelope"></i>user@yoursite.com</a>
                    <a href="javascript:void(0);" title="">{{ __('LETS TALK') }} <i class="far {{ app()->getLocale() == 'ar' ? 'fa-long-arrow-left' : 'fa-long-arrow-right' }}"></i></a>
                </div><!-- Contact Links -->
            </div><!-- Logo Menu Inner -->
        </div>
    </div><!-- Logo Menu Wrapper -->
</header><!-- Header -->

<div class="content-offset"></div>