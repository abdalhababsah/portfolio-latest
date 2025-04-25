<section id="contact">
    <div class="position-relative pt-110 w-100">
        <div class="contact-wrap round15 position-relative w-100">
            <div class="row">
                <div class="col-lg-5">
                    <div class="sec-title-wrap mb-40">
                        <div class="sec-title">
                            <span class="sec-sub rounded-pill text-center">{{ __('Want to Hire Me?') }}</span>
                            <h2 class="mt-4 sz-40">
                                {{ __('Let\'s Work Together On Project') }}</h2>
                        </div>
                    </div>
                    <div class="cont-info mb-40 d-inline-flex align-items-center gap-2">
                        <span><i class="fas fa-phone"></i></span>
                        <div class="cont-info-inner d-flex align-items-start flex-column">
                            <span>{{ __('Contact Me At:') }}</span>
                            <a href="tel:{{ $settings['phone'] ?? '' }}"
                                title="{{ __('Call Us') }}">{{ $settings['phone'] ?? '(000) 000-0000' }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    {{-- A simple contact form (no backend included) --}}
                    <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-12">
                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="{{ __('Full Name *') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="{{ __('Email *') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input name="subject" class="form-control @error('subject') is-invalid @enderror"
                                    value="{{ old('subject') }}" placeholder="{{ __('Your Subject *') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                                    placeholder="{{ __('Write your message here...') }}" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="theme-btn2 round10" style="color:#C19A6B">
                                    {{ __('Send Message') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Replace the existing flash message in your contact section -->
                    @if (session('status'))
                        <div class="toast-notification" id="successToast">
                            <div class="toast-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="toast-content">
                                <p>{{ session('status') }}</p>
                            </div>
                            <button class="toast-close" onclick="closeToast()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Add this CSS to your stylesheet -->
<style>
    /* Toast Notification */
    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #252525;
        color: #ffffff;
        border-left: 4px solid var(--scheme1);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        border-radius: var(--round10);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        max-width: 350px;
        z-index: 1000;
        animation: slideIn 0.5s forwards, fadeOut 0.5s 5s forwards;
        overflow: hidden;
    }

    /* Progress bar effect on the bottom */
    .toast-notification::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: var(--scheme1);
        animation: shrink 5s linear forwards;
    }

    .toast-icon {
        flex-shrink: 0;
        font-size: 24px;
        margin-right: 15px;
        color: var(--scheme1);
    }

    .toast-content {
        flex-grow: 1;
    }

    .toast-content p {
        margin: 0;
        font-family: var(--Bricolage-Grotesque);
        font-size: 16px;
    }

    .toast-close {
        background: none;
        border: none;
        color: var(--color3);
        cursor: pointer;
        font-size: 16px;
        padding: 0;
        margin-left: 15px;
        transition: color 0.3s;
    }

    .toast-close:hover {
        color: var(--white);
    }

    /* Animations */
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            visibility: hidden;
        }
    }

    @keyframes shrink {
        from {
            width: 100%;
        }

        to {
            width: 0;
        }
    }

    /* Light mode styles */
    .light .toast-notification {
        background-color: var(--white);
        color: var(--color7);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* RTL Support */
    html[dir="rtl"] .toast-notification {
        left: 30px;
        right: auto;
        border-left: none;
        border-right: 4px solid var(--scheme1);
    }

    html[dir="rtl"] .toast-icon {
        margin-right: 0;
        margin-left: 15px;
    }

    html[dir="rtl"] .toast-close {
        margin-left: 0;
        margin-right: 15px;
    }

    html[dir="rtl"] @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<!-- Add this JavaScript to your scripts -->
<script>
    // Close toast manually
    function closeToast() {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.style.animation = 'fadeOut 0.5s forwards';
            setTimeout(() => {
                toast.remove();
            }, 500);
        }
    }

    // Auto-remove toast after animation completes
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('successToast');
        if (toast) {
            setTimeout(() => {
                toast.remove();
            }, 5500); // 5s display + 0.5s fadeout
        }
    });
</script>
