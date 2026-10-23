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
    let paused = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
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

      const file = this.files[0];
      const maxBytes = 10 * 1024 * 1024;
      const isPdfField = this.accept.toLowerCase().split(',').some(type => type.trim() === '.pdf' || type.trim() === 'application/pdf');
      const extensionIsPdf = file.name.toLowerCase().endsWith('.pdf');
      const mimeIsPdf = file.type === 'application/pdf' || file.type === '';
      if (file.size > maxBytes || (isPdfField && (!extensionIsPdf || !mimeIsPdf))) {
        this.value = '';
        if (label) label.textContent = 'فایل نامعتبر است؛ PDF حداکثر ۱۰ مگابایت انتخاب کنید';
        showAlert('فایل انتخاب‌شده معتبر نیست. برای مقاله، PDF حداکثر ۱۰ مگابایت انتخاب کنید.', 'danger');
        return;
      }
      if (label) label.textContent = file.name;
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

function loginDemo(email, role) {
  const user = {
    name: role === 'admin' ? 'مدیر سیستم (دمو)' : 'کاربر نمونه (دمو)',
    email: email || 'user@example.com',
    role: role || 'user',
    demo: true
  };
  localStorage.setItem('conference_user', JSON.stringify(user));
  showAlert('ورود نمایشی انجام شد؛ این ورود امن نیست و حساب واقعی ایجاد نمی‌کند.', 'info');
  window.setTimeout(() => {
    if (role === 'admin') {
      window.location.href = 'admin-dashboard.html';
    } else if (role === 'reviewer') {
      window.location.href = 'reviewer-dashboard.html';
    } else {
      window.location.href = 'dashboard.html';
    }
  }, 1400);
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
