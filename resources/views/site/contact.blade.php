@extends('site.layout')

@section('title', __('lang.CONTACT_TITLE'))

@section('head')
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Custom Styles -->
  <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
  <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
  <link rel='stylesheet' href="{{ asset('lib/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('styles/contact.css') }}">
  <style>
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .grid-2 { grid-template-columns: 1fr !important; }
      .container { padding: 1rem; margin: 1rem auto; }
      h1 { font-size: 2rem; }
      .header button { font-size: 1.25rem; }
    }
  </style>
@endsection

@section('content')
<div class="container contact-controller" data-theme="dark">
  <div class="header">
    <h1>{{ __('lang.CONTACT_HEADING') }}</h1>
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
      <i class="fas fa-sun"></i>
    </button>
  </div>
  <p>{{ __('lang.CONTACT_INTRO') }}</p>
  <div class="grid grid-2">
    {{-- Contact Form --}}
    <form id="contactForm" action="" method="POST">
      @csrf
      <div class="form-group">
        <label for="email">{{ __('lang.FORM_EMAIL') }}</label>
        <input type="email" id="email" name="email" placeholder="{{ __('lang.FORM_EMAIL_PLACEHOLDER') }}" required>
      </div>
      <div class="form-group">
        <label for="phone">{{ __('lang.FORM_PHONE') }}</label>
        <input type="tel" id="phone" name="phone" placeholder="{{ __('lang.FORM_PHONE_PLACEHOLDER') }}" required>
      </div>
      <div class="form-group">
        <label for="subject">{{ __('lang.FORM_SUBJECT') }}</label>
        <input type="text" id="subject" name="subject" placeholder="{{ __('lang.FORM_SUBJECT_PLACEHOLDER') }}" required>
      </div>
      <div class="form-group">
        <label for="message">{{ __('lang.FORM_MESSAGE') }}</label>
        <textarea id="message" name="message" placeholder="{{ __('lang.FORM_MESSAGE_PLACEHOLDER') }}" required></textarea>
      </div>
      <button type="submit"><i class="fas fa-paper-plane"></i> {{ __('lang.FORM_SEND') }}</button>
    </form>

    {{-- QR Code modal --}}
    <div id="qrModal" class="modal">
      <span class="close" id="closeModal">&times;</span>
      <img class="modal-content" src="{{ asset('images/alrajhi-qrcode.jpeg') }}" alt="QR Code">
    </div>


    {{-- Sidebar Info --}}
    <aside class="sidebar">
      {{-- Address --}}
      <div class="info-group">
        <h3><i class="fas fa-map-marker-alt"></i> {{ __('lang.CONTACT_ADDRESS') }}</h3>
        <p>{{ __('lang.CONTACT_ADDRESS_VALUE') }}</p>
      </div>
      {{-- Email --}}
      <div class="info-group">
        <h3><i class="fas fa-envelope"></i> {{ __('lang.CONTACT_EMAIL') }}</h3>
        <p><a href="mailto:fazlielahi03060155124@gmail.com">fazlielahi03060155124@gmail.com</a></p>
      </div>
      {{-- Phone --}}
      <div class="info-group">
        <h3><i class="fas fa-phone"></i> {{ __('lang.CONTACT_PHONE') }}</h3>
        <p>{{ __('lang.CONTACT_PHONE') }}: <a href="tel:+966592304816">+966592304816</a></p>
        <p>{{ __('lang.CONTACT_WHATSAPP') }}: <a href="https://wa.me/966592304816" target="_blank">+966592304816</a></p>
      </div>
      {{-- Bank SA --}}
      <div class="info-group">
        <h3><i class="fas fa-university"></i> {{ __('lang.CONTACT_BANK_SA') }}</h3>
        <p>{{ __('lang.CONTACT_BANK_NAME') }}: {{ __('lang.CONTACT_BANK_SA_NAME') }} <span class="qr-code" id="openModal"> - {{ __('lang.SCAN_QR_CODE') }}</span> </p>
        <p>{{ __('lang.CONTACT_BANK_BRANCH') }}: {{ __('lang.CONTACT_BANK_SA_BRANCH') }}</p>
        <p>{{ __('lang.CONTACT_BANK_ACCOUNT') }}: {{ __('lang.AUTHOR_NAME') }}</p>
        <p>{{ __('lang.CONTACT_BANK_IBAN') }}: SA67 8000 0856 6080 1949 1536</p>
        <p>{{ __('lang.CONTACT_PAYMENT_NOTE') }}</p>
      </div>
      {{-- Bank PK --}}
      <div class="info-group">
        <h3><i class="fas fa-university"></i> {{ __('lang.CONTACT_BANK_PK') }}</h3>
        <p>{{ __('lang.CONTACT_BANK_NAME') }} 1: {{ __('lang.CONTACT_BANK_PK_NAME1') }}</p>
        <p>{{ __('lang.CONTACT_BANK_BRANCH') }}: {{ __('lang.CONTACT_BANK_PK_BRANCH1') }}</p>
        <p>{{ __('lang.CONTACT_BANK_ACCOUNT') }}: {{ __('lang.AUTHOR_NAME') }}</p>
        <p>{{ __('lang.CONTACT_BANK_IBAN') }}: PK70 MEZN 0008160109497682</p>
        <p>{{ __('lang.CONTACT_BANK_NAME') }} 2: {{ __('lang.CONTACT_BANK_PK_NAME2') }}</p>
        <p>{{ __('lang.CONTACT_BANK_ACCOUNT') }}: {{ __('lang.AUTHOR_NAME') }}</p>
        <p>{{ __('lang.CONTACT_BANK_PK_MOBILE') }}: <a href="tel:+923060155124">+923060155124</a></p>
      </div>
      {{-- Social --}}
      <div class="info-group">
        <h3><i class="fas fa-share-alt"></i> {{ __('lang.CONTACT_SOCIAL') }}</h3>
        <div class="social-icons">
          <a href="https://www.linkedin.com/in/fazlielahi/" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
          <a href="https://www.facebook.com/fazlie.lahi.50" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
          <a href="https://github.com/fazlielahi" aria-label="GitHub"><i class="fab fa-github"></i></a>
          <a href="https://wa.me/966592304816" target="_blank" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
          </a>
        </div>
      </div>
    </aside>
  </div>
</div>
@endsection

@section('script')

  <script>
    // Set default theme to dark
    document.documentElement.setAttribute('data-theme', 'dark');

    // Theme toggle
    const toggleBtn = document.getElementById('themeToggle');
    toggleBtn.addEventListener('click', () => {
      const html = document.documentElement;
      const current = html.getAttribute('data-theme');
      const next = current === 'light' ? 'dark' : 'light';
      html.setAttribute('data-theme', next);
      toggleBtn.innerHTML = next === 'light' ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
    });

    // SweetAlert on submit
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      Swal.fire({
        icon: 'success',
        title: '{{ __('lang.ALERT_SUCCESS_TITLE') }}',
        text: '{{ __('lang.ALERT_SUCCESS_TEXT') }}',
        confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--primary')
      }).then(() => {
        this.submit();
      });
    });
  </script>

  <!-- QR CODE MODAL  -->
  <script>
    const modal = document.getElementById("qrModal");
    const openBtn = document.getElementById("openModal");
    const closeBtn = document.getElementById("closeModal");

    openBtn.onclick = function() {
      modal.style.display = "block";
    }

    closeBtn.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

  <script src="{{ asset('js/menu.js') }}"></script>
  <script src="{{ asset('lib/bootstrap-5.3.2-dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>

@endsection
