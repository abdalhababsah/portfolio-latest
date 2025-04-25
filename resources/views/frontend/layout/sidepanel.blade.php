<!-- Enhanced Sidepanel with original color buttons -->
<div class="sidepanel bg-color5 d-flex flex-column gap-5">
    <span class="d-flex align-items-center justify-content-center bg-color5">
        <i class="far fa-cog"></i>
    </span>
    
    <div class="sidepanel-header">
        <div class="sidepanel-title">{{ __('Customize Theme') }}</div>
        <div class="sidepanel-subtitle">{{ __('Personalize Your Experience') }}</div>
    </div>
    
    <div class="sidepanel-box d-flex flex-column align-items-start gap-4">
        <h6 class="mb-0 fw-normal">{{ __('Choose Your Color') }}</h6>
        <div class="color-picker d-flex flex-wrap align-items-start w-100 gap-2">
            <a class="scheme1-color applied" href="javascript:void(0);" title=""></a>
            <a class="scheme2-color " href="javascript:void(0);" title=""></a>
            <a class="scheme3-color" href="javascript:void(0);" title=""></a>
            <a class="scheme4-color" href="javascript:void(0);" title=""></a>
            <a class="scheme5-color" href="javascript:void(0);" title=""></a>
        </div><!-- Color Picker -->
    </div><!-- Side Panel Box -->
    
    <div class="sidepanel-box d-flex flex-column align-items-start gap-4">
        <h6 class="mb-0 fw-normal">{{ __('Choose Your Skin Mode') }}</h6>
        <div class="skin-mode d-flex flex-wrap align-items-start w-100 gap-2">
            <a class="dark-mode" href="javascript:void(0);" title="">{{ __('Dark') }}</a>
            <a class="light-mode applied" href="javascript:void(0);" title="">{{ __('Light') }}</a>
        </div><!-- Skin Mode -->
    </div><!-- Side Panel Box -->

    <div class="sidepanel-box d-flex flex-column align-items-start gap-4">
        <h6 class="mb-0 fw-normal">{{ __('Language') }}</h6>
        <div class="language-switcher d-flex flex-wrap align-items-start w-100 gap-2">
            <a class="lang-option {{ app()->getLocale() == 'en' ? 'applied' : '' }}" href="{{ route('locale.switch', 'en') }}">
                <span class="flag-icon">🇺🇸</span> {{ __('English') }}
            </a>
            <a class="lang-option {{ app()->getLocale() == 'ar' ? 'applied' : '' }}" href="{{ route('locale.switch', 'ar') }}">
                <span class="flag-icon">🇸🇦</span> {{ __('Arabic') }}
            </a>
        </div>
    </div>
    
    <div class="sidepanel-footer">
        <p>{{ __('Settings are saved automatically') }}</p>
    </div>
</div>