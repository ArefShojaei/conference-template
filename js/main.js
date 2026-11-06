/* ============================================
   قالب همایش - اسکریپت رابط کاربری ایستا
   توجه: این فایل backend یا ذخیره‌سازی واقعی فراهم نمی‌کند.
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {
  // Mobile menu
  const menuToggle = document.querySelector('.menu-toggle');
  const navMenu = document.querySelector('.nav-menu');
  if (menuToggle && navMenu) {
    menuToggle.setAttribute('aria-expanded', 'false');
    menuToggle.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('show');
      menuToggle.setAttribute('aria-expanded', String(isOpen));
    });
  }

  // Mobile dropdown navigation: first tap expands; a second tap follows the parent link.
  if (navMenu) {
    const dropdownLinks = navMenu.querySelectorAll('.nav-item.has-dropdown > a');
    dropdownLinks.forEach(anchor => {
      const item = anchor.parentElement;
      anchor.setAttribute('aria-expanded', 'false');
      anchor.addEventListener('click', event => {
        if (!window.matchMedia('(max-width: 1180px)').matches) return;
        if (!item.classList.contains('is-open')) {
          event.preventDefault();
          navMenu.querySelectorAll('.nav-item.has-dropdown.is-open').forEach(openItem => {
            if (openItem !== item) {
              openItem.classList.remove('is-open');
              const openLink = openItem.querySelector(':scope > a');
              if (openLink) openLink.setAttribute('aria-expanded', 'false');
            }
          });
          item.classList.add('is-open');
          anchor.setAttribute('aria-expanded', 'true');
        }
      });
    });
    navMenu.querySelectorAll('a').forEach(link => {
      if (link.matches('.nav-item.has-dropdown > a')) return;
      link.addEventListener('click', () => {
        if (!window.matchMedia('(max-width: 1180px)').matches) return;
        navMenu.classList.remove('show');
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Accessible homepage carousel: autoplay pauses on interaction, focus, hover and reduced motion.
  document.querySelectorAll('[data-carousel]').forEach(carousel => {
    const slides = Array.from(carousel.querySelectorAll('[data-slide]'));
    const dots = Array.from(carousel.querySelectorAll('[data-slide-to]'));
    const prev = carousel.querySelector('[data-slide-prev]');
    const next = carousel.querySelector('[data-slide-next]');
    const pause = carousel.querySelector('[data-slide-pause]');
    if (slides.length < 2) return;
    let active = Math.max(0, slides.findIndex(slide => slide.classList.contains('is-active')));
    let timer = null;
    let paused = false; // Keep the original automatic carousel rotation enabled.
    const show = index => {
      active = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => {
        const selected = i === active;
        slide.classList.toggle('is-active', selected);
        slide.setAttribute('aria-hidden', String(!selected));
      });
      dots.forEach((dot, i) => {
        const selected = i === active;
        dot.classList.toggle('is-active', selected);
        dot.setAttribute('aria-pressed', String(selected));
      });
    };
    const stop = () => { if (timer) window.clearInterval(timer); timer = null; };
    const start = () => {
      stop();
      if (paused || document.hidden) return;
      timer = window.setInterval(() => show(active + 1), 6500);
    };
    const userNavigate = index => { show(index); start(); };
    if (prev) prev.addEventListener('click', () => userNavigate(active - 1));
    if (next) next.addEventListener('click', () => userNavigate(active + 1));
    dots.forEach((dot, i) => dot.addEventListener('click', () => userNavigate(i)));
    if (pause) pause.addEventListener('click', () => {
      paused = !paused;
      pause.setAttribute('aria-pressed', String(paused));
      pause.setAttribute('aria-label', paused ? 'ادامه حرکت خودکار' : 'توقف حرکت خودکار');
      pause.textContent = paused ? '▶' : 'Ⅱ';
      start();
    });
    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    carousel.addEventListener('focusin', stop);
    carousel.addEventListener('focusout', start);
    document.addEventListener('visibilitychange', start);
    show(active);
    start();
  });

  // Password visibility toggle for auth pages.
  document.querySelectorAll('[data-password-toggle]').forEach(button => {
    button.addEventListener('click', () => {
      const field = document.getElementById(button.dataset.passwordToggle);
      if (!field) return;
      const reveal = field.type === 'password';
      field.type = reveal ? 'text' : 'password';
      button.setAttribute('aria-label', reveal ? 'پنهان‌کردن رمز عبور' : 'نمایش رمز عبور');
      button.setAttribute('aria-pressed', String(reveal));
    });
  });

  // Mobile OTP flow preview. Static HTML never sends or verifies a real SMS.
  document.querySelectorAll('form[data-phone-otp]').forEach(form => {
    const phone = form.querySelector('input[name="phone"]');
    const requestButton = form.querySelector('[data-otp-request]');
    const otpStep = form.querySelector('[data-otp-step]');
    const otpField = otpStep && otpStep.querySelector('input[name="otp"]');
    if (!phone || !requestButton || !otpStep || !otpField) return;

    const normalizeDigits = value => value
      .replace(/[۰-۹]/g, d => String('۰۱۲۳۴۵۶۷۸۹'.indexOf(d)))
      .replace(/[٠-٩]/g, d => String('٠١٢٣٤٥٦٧٨٩'.indexOf(d)))
      .replace(/[\s-]/g, '');
    const validIranMobile = value => /^(09[0-9]{9}|\+989[0-9]{9}|00989[0-9]{9})$/.test(value);

    requestButton.addEventListener('click', () => {
      phone.value = normalizeDigits(phone.value);
      if (!validIranMobile(phone.value)) {
        phone.setCustomValidity('شماره موبایل معتبر ایران را وارد کنید؛ مانند 09123456789.');
        phone.reportValidity();
        return;
      }
      phone.setCustomValidity('');
      const requiredFields = Array.from(form.querySelectorAll('[required]')).filter(field => field !== otpField);
      const invalid = requiredFields.find(field => field.type === 'checkbox' ? !field.checked : !field.value.trim());
      if (invalid) {
        invalid.reportValidity();
        return;
      }
      otpStep.hidden = false;
      otpField.required = true;
      otpField.focus();
      requestButton.disabled = true;
      requestButton.textContent = 'مرحله کد تأیید باز شد';
      const note = otpStep.querySelector('[data-otp-preview-message]');
      if (note) note.textContent = 'پیش‌نمایش: در این نسخه هیچ پیامکی ارسال نشده است. پس از اتصال درگاه پیامک، کد واقعی به شماره ثبت‌شده ارسال می‌شود.';
      showAlert('مرحله کد یک‌بارمصرف نمایش داده شد؛ ارسال پیامک در نسخه HTML فعال نیست.', 'info');
    });

    form.addEventListener('submit', event => {
      event.preventDefault();
      phone.value = normalizeDigits(phone.value);
      otpField.value = normalizeDigits(otpField.value);
      if (!validIranMobile(phone.value) || !form.reportValidity()) return;
      showAlert('برای تأیید واقعی کد و ورود، اتصال API امن وردپرس و سرویس پیامکی لازم است.', 'info');
    });
  });

  // Tabs
  document.querySelectorAll('.tabs').forEach(tabGroup => {
    const buttons = tabGroup.querySelectorAll('.tab-btn');
    const contents = tabGroup.parentElement.querySelectorAll('.tab-content');
    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.tab;
        buttons.forEach(button => {
          const active = button === btn;
          button.classList.toggle('active', active);
          button.setAttribute('aria-selected', String(active));
        });
        contents.forEach(content => {
          content.classList.toggle('active', content.id === target);
        });
      });
    });
  });

  // Modals
  document.querySelectorAll('[data-modal]').forEach(trigger => {
    trigger.addEventListener('click', event => {
      event.preventDefault();
      const modal = document.getElementById(trigger.dataset.modal);
      if (modal) {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
      }
    });
  });

  document.querySelectorAll('.modal-close, .modal-overlay').forEach(element => {
    element.addEventListener('click', event => {
      if (event.target !== element) return;
      const modal = element.closest('.modal-overlay') || element;
      modal.classList.remove('show');
      modal.setAttribute('aria-hidden', 'true');
    });
  });

  // Static forms: validate locally, but never claim data was saved.
  document.querySelectorAll('form[data-validate]').forEach(form => {
    form.addEventListener('submit', event => {
      event.preventDefault();
      const requiredFields = Array.from(form.querySelectorAll('[required]'));
      let valid = true;

      requiredFields.forEach(field => {
        const fieldValid = field.type === 'checkbox'
          ? field.checked
          : (field.type === 'file' ? field.files.length > 0 : field.value.trim() !== '');
        field.style.borderColor = fieldValid ? '' : '#ef4444';
        if (!fieldValid) valid = false;
      });

      form.querySelectorAll('[data-confirm-password]').forEach(field => {
        const source = form.querySelector('#' + CSS.escape(field.dataset.confirmPassword));
        const matches = !!source && field.value === source.value;
        field.style.borderColor = matches ? '' : '#ef4444';
        if (!matches) {
          valid = false;
          field.setCustomValidity('رمز عبور و تکرار آن یکسان نیستند.');
        } else {
          field.setCustomValidity('');
        }
      });

      if (valid && typeof form.reportValidity === 'function' && !form.checkValidity()) {
        valid = false;
        form.reportValidity();
      }

      if (!valid) {
        showAlert('لطفاً فیلدهای الزامی را بررسی کنید.', 'danger');
        return;
      }

      showAlert('اعتبارسنجی انجام شد؛ این نسخه ایستا است و اطلاعات را ذخیره یا ارسال نمی‌کند.', 'info');
    });
  });

  // File chooser: avoid bubbling a programmatic input click back to its wrapper.
  document.querySelectorAll('.file-upload').forEach(wrapper => {
    const input = wrapper.querySelector('input[type="file"]');
    if (!input) return;

    wrapper.setAttribute('role', 'button');
    wrapper.setAttribute('tabindex', '0');
    if (!wrapper.hasAttribute('aria-label')) {
      wrapper.setAttribute('aria-label', 'انتخاب فایل');
    }
    wrapper.addEventListener('click', event => {
      if (event.target !== input) input.click();
    });
    wrapper.addEventListener('keydown', event => {
      if (event.target === wrapper && (event.key === 'Enter' || event.key === ' ')) {
        event.preventDefault();
        input.click();
      }
    });
    input.addEventListener('change', function () {
      const label = wrapper.querySelector('.file-name');
      if (!this.files || !this.files.length) {
        if (label) label.textContent = 'فایلی انتخاب نشده است';
        return;
      }

      const files = Array.from(this.files);
      const maxBytes = this.dataset.fileRole === 'supplementary' ? 20 * 1024 * 1024 : 10 * 1024 * 1024;
      const accepted = this.accept.toLowerCase().split(',').map(type => type.trim());
      const extensions = accepted.filter(type => type.startsWith('.'));
      if (accepted.includes('application/pdf')) extensions.push('.pdf');
      if (accepted.includes('application/msword')) extensions.push('.doc');
      if (accepted.includes('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) extensions.push('.docx');
      const invalid = files.some(file => {
        const extension = '.' + file.name.toLowerCase().split('.').pop();
        return file.size > maxBytes || (extensions.length > 0 && !extensions.includes(extension));
      });
      if (invalid) {
        this.value = '';
        if (label) label.textContent = this.dataset.fileRole === 'supplementary'
          ? 'فایل نامعتبر است؛ فایل مکمل حداکثر ۲۰ مگابایت انتخاب کنید'
          : 'فایل نامعتبر است؛ PDF یا Word حداکثر ۱۰ مگابایت انتخاب کنید';
        showAlert('نوع یا حجم یکی از فایل‌های انتخاب‌شده مجاز نیست.', 'danger');
        return;
      }
      if (label) label.textContent = files.length > 1 ? files.length + ' فایل انتخاب شد' : files[0].name;
    });
  });

  // Keep password confirmation in sync with native browser validation.
  document.querySelectorAll('[data-confirm-password]').forEach(field => {
    const form = field.form;
    const source = form && form.querySelector('#' + CSS.escape(field.dataset.confirmPassword));
    if (!source) return;
    const validateMatch = () => {
      field.setCustomValidity(field.value && field.value !== source.value ? 'رمز عبور و تکرار آن یکسان نیستند.' : '');
    };
    field.addEventListener('input', validateMatch);
    source.addEventListener('input', validateMatch);
  });

  // Highlight active navigation link.
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-menu a, .sidebar-nav a').forEach(link => {
    const href = link.getAttribute('href');
    if (href && (href === currentPage || href.endsWith('/' + currentPage))) {
      link.classList.add('active');
    }
  });

  // localStorage authentication is a demo only, never a security boundary.
  let user = null;
  try {
    user = JSON.parse(localStorage.getItem('conference_user') || 'null');
  } catch (error) {
    localStorage.removeItem('conference_user');
  }
  updateAuthUI(user);
});

function showAlert(message, type = 'info') {
  document.querySelectorAll('.toast-alert').forEach(existing => existing.remove());
  const alert = document.createElement('div');
  alert.className = 'alert alert-' + type + ' toast-alert';
  alert.setAttribute('role', type === 'danger' ? 'alert' : 'status');
  alert.style.cssText = 'position:fixed;top:20px;left:50%;transform:translateX(-50%);z-index:9999;min-width:min(300px,90vw);max-width:90vw;box-shadow:0 10px 25px rgba(0,0,0,0.15);';
  const text = document.createElement('span');
  text.textContent = message;
  alert.appendChild(text);
  document.body.appendChild(alert);
  window.setTimeout(() => alert.remove(), 5000);
}

function updateAuthUI(_user) {
  // Auth state is handled per-page for this static preview.
}

function logout() {
  localStorage.removeItem('conference_user');
  showAlert('از حالت نمایشی خارج شدید.', 'info');
  window.setTimeout(() => window.location.href = 'index.html', 800);
}

// Counter animation
function animateCounters() {
  document.querySelectorAll('[data-count]').forEach(element => {
    const target = Number.parseInt(element.dataset.count, 10);
    if (!Number.isFinite(target)) return;
    let current = 0;
    const step = Math.max(target / 50, 1);
    const timer = window.setInterval(() => {
      current += step;
      if (current >= target) {
        element.textContent = target.toLocaleString('fa-IR');
        window.clearInterval(timer);
      } else {
        element.textContent = Math.floor(current).toLocaleString('fa-IR');
      }
    }, 30);
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', animateCounters, { once: true });
} else {
  animateCounters();
}


/* Reliable off-canvas navigation for admin and participant panels. */
(function () {
  function initPanelDrawers() {
    document.querySelectorAll('.admin-app .admin-layout').forEach(function (layout, index) {
      const app = layout.closest('.admin-app');
      const sidebar = layout.querySelector('.admin-sidebar');
      const topbar = app && app.querySelector('.admin-topbar');
      if (!sidebar || !topbar) return;

      let toggle = topbar.querySelector('.panel-menu-toggle');
      if (!toggle) {
        toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'panel-menu-toggle';
        toggle.innerHTML = '<span class="panel-menu-toggle-icon" aria-hidden="true">☰</span><span class="panel-menu-toggle-label">منو</span>';
        topbar.insertBefore(toggle, topbar.firstElementChild);
      }
      toggle.setAttribute('aria-label', 'باز کردن منوی پنل');
      toggle.setAttribute('aria-expanded', 'false');

      const sidebarId = sidebar.id || ('panel-sidebar-' + (index + 1));
      sidebar.id = sidebarId;
      toggle.setAttribute('aria-controls', sidebarId);

      let overlay = layout.querySelector('.panel-menu-overlay');
      if (!overlay) {
        overlay = document.createElement('button');
        overlay.type = 'button';
        overlay.className = 'panel-menu-overlay';
        overlay.setAttribute('aria-label', 'بستن منوی پنل');
        overlay.setAttribute('tabindex', '-1');
        layout.appendChild(overlay);
      }

      function closeMenu() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        sidebar.style.removeProperty('transform');
        sidebar.style.removeProperty('visibility');
        sidebar.style.removeProperty('opacity');
        sidebar.querySelectorAll('.admin-nav, .admin-nav-label, .admin-nav > a').forEach(function (item) {
          item.style.removeProperty('visibility');
          item.style.removeProperty('opacity');
          item.style.removeProperty('display');
        });
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'باز کردن منوی پنل');
        document.body.classList.remove('panel-menu-open');
      }

      function openMenu() {
        sidebar.classList.add('is-open');
        sidebar.style.setProperty('transform', 'translateX(0)', 'important');
        sidebar.style.setProperty('visibility', 'visible', 'important');
        sidebar.style.setProperty('opacity', '1', 'important');
        sidebar.querySelectorAll('.admin-nav, .admin-nav-label, .admin-nav > a').forEach(function (item) {
          item.style.setProperty('visibility', 'visible', 'important');
          item.style.setProperty('opacity', '1', 'important');
          item.style.setProperty('display', item.matches('.admin-nav') ? 'flex' : (item.matches('.admin-nav-label') ? 'block' : 'flex'), 'important');
        });
        overlay.classList.add('is-visible');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'بستن منوی پنل');
        document.body.classList.add('panel-menu-open');
      }

      toggle.onclick = function () {
        sidebar.classList.contains('is-open') ? closeMenu() : openMenu();
      };
      overlay.onclick = closeMenu;
      sidebar.querySelectorAll('a').forEach(function (link) {
        link.onclick = function () {
          if (window.matchMedia('(max-width: 900px)').matches) closeMenu();
        };
      });
      if (!layout.dataset.panelDrawerBound) {
        layout.dataset.panelDrawerBound = 'true';
        document.addEventListener('keydown', function (event) {
          if (event.key === 'Escape') closeMenu();
        });
        window.addEventListener('resize', function () {
          if (window.innerWidth > 900) closeMenu();
        });
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPanelDrawers, { once: true });
  } else {
    initPanelDrawers();
  }
})();