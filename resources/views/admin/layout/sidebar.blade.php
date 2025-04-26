{{-- resources/views/layouts/partials/_sidebar.blade.php --}}
<div class="sidenav-menu">

    {{-- ─── Brand ─────────────────────────────────────────────────────── --}}
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-light align-text-center">
            <span class="logo-lg " style="font-size: x-large; color: #c19b6a;">AL-HABABSEH</span>
            <span class="logo-sm" style="color: #c19b6a;">AH</span>
        </span>
        <span class="logo-dark align-text-center">
            <span class="logo-lg" style="font-size: x-large; color: #c19b6a;">AL-HABABSEH</span>
            <span class="logo-sm" style="color: #c19b6a;">AH</span>
        </span>
    </a>

    {{-- collapse / hover buttons (unchanged) --}}
    <button class="button-sm-hover"><i class="ti ti-circle"></i></button>
    <button class="button-close-fullsidebar"><i class="ti ti-x"></i></button>

    <div data-simplebar>
        <ul class="side-nav">

            {{-- ========================= Core ========================= --}}
            <li class="side-nav-title">Core</li>

            <li class="side-nav-item">
                <a href="{{ route('dashboard') }}"
                    class="side-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-home"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            {{-- ===================== Portfolio ======================= --}}
            <li class="side-nav-title mt-2">Portfolio</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.projects.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.projects.index') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-layout-kanban"></i></span>
                    <span class="menu-text">Projects</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.projects.create') }}"
                    class="side-nav-link {{ request()->routeIs('admin.projects.create') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-plus"></i></span>
                    <span class="menu-text">Create Project</span>
                </a>
            </li>

            {{-- ===================== Profile ========================= --}}
            <li class="side-nav-title mt-2">Profile</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.experiences.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                    <span class="menu-text">Experience</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.educations.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.educations.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-school"></i></span>
                    <span class="menu-text">Education</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.skills.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-award"></i></span>
                    <span class="menu-text">Skills</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.technologies.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.technologies.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-cpu"></i></span>
                    <span class="menu-text">Technologies</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.certificates.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-certificate"></i></span>
                    <span class="menu-text">Certificates</span>
                </a>
            </li>

            {{-- =================== Content & Meta ==================== --}}
            <li class="side-nav-title mt-2">Content</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.tags.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-tag"></i></span>
                    <span class="menu-text">Tags</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.faqs.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-help-circle"></i></span>
                    <span class="menu-text">FAQs</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.testimonials.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-message-dots"></i></span>
                    <span class="menu-text">Testimonials</span>
                </a>
            </li>

            {{-- ================== Communication ===================== --}}
            <li class="side-nav-title mt-2">Communication</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.contacts.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-mail"></i></span>
                    <span class="menu-text">Contacts</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.social-links.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-world-www"></i></span>
                    <span class="menu-text">Social Links</span>
                </a>
            </li>

            {{-- ================== Services ========================== --}}
            <li class="side-nav-title mt-2">Services</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.services.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.services.index') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-box"></i></span>
                    <span class="menu-text">All Services</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.services.create') }}"
                    class="side-nav-link {{ request()->routeIs('admin.services.create') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-plus"></i></span>
                    <span class="menu-text">Create Service</span>
                </a>
            </li>

            {{-- ================== Settings ========================== --}}
            <li class="side-nav-title mt-2">System</li>

            <li class="side-nav-item mb-2">
                <a href="{{ route('admin.site-settings.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-settings"></i></span>
                    <span class="menu-text">Site Settings</span>
                </a>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
