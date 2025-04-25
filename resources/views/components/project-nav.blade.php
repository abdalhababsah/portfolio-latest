{{-- resources/views/components/project-nav.blade.php --}}
@props(['previous' => null, 'next' => null])

<div class="projects-navigation d-flex justify-content-between mt-5 pt-4 border-top">
    {{-- Previous project --}}
    <div class="prev-project">
        @if($previous)
            <a href="{{ route('projects.show', $previous->slug) }}" class="d-flex align-items-center">
                <i class="fas {{ app()->getLocale() == 'ar' ? 'fa-arrow-right ms-2' : 'fa-arrow-left me-2' }}"></i>
                <div>
                    <small>{{ __('Previous Project') }}</small>
                    <h5 class="mb-0">{{ Str::limit($previous->title, 20) }}</h5>
                </div>
            </a>
        @endif
    </div>

    {{-- Next project --}}
    <div class="next-project text-end">
        @if($next)
            <a href="{{ route('projects.show', $next->slug) }}" class="d-flex align-items-center justify-content-end">
                <div>
                    <small>{{ __('Next Project') }}</small>
                    <h5 class="mb-0">{{ Str::limit($next->title, 20) }}</h5>
                </div>
                <i class="fas {{ app()->getLocale() == 'ar' ? 'fa-arrow-left ms-2' : 'fa-arrow-right me-2' }}"></i>
            </a>
        @endif
    </div>
</div>