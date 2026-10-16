/* ============================================
   قالب همایش - اسکریپت اصلی
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {
  // Mobile Menu Toggle
  const menuToggle = document.querySelector('.menu-toggle');
  const navMenu = document.querySelector('.nav-menu');
  if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
      navMenu.classList.toggle('show');
    });
  }

  // Tabs
  document.querySelectorAll('.tabs').forEach(tabGroup => {
    const buttons = tabGroup.querySelectorAll('.tab-btn');
    const contents = tabGroup.parentElement.querySelectorAll('.tab-content');
    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.tab;
        buttons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        contents.forEach(c => {
          c.classList.toggle('active', c.id === target);
        });
      });
    });
  });

  // Modal
  document.querySelectorAll('[data-modal]').forEach(trigger => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const modalId = trigger.dataset.modal;
      const modal = document.getElementById(modalId);
      if (modal) modal.classList.add('show');
    });
  });

  document.querySelectorAll('.modal-close, .modal-overlay').forEach(el => {
    el.addEventListener('click', (e) => {
      if (e.target === el) {
        el.closest('.modal-overlay')?.classList.remove('show');
        if (el.classList.contains('modal-overlay')) el.classList.remove('show');
      }
    });
  });

  // Form Validation Demo
  document.querySelectorAll('form[data-validate]').forEach(form => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      let valid = true;
      form.querySelectorAll('[required]').forEach(input => {
        if (!input.value.trim()) {
          valid = false;
          input.style.borderColor = '#ef4444';
        } else {
          input.style.borderColor = '';
        }
      });
      if (valid) {
        showAlert('عملیات با موفقیت انجام شد!', 'success');
        // Simulate redirect or success
        const successMsg = form.dataset.success;
        if (successMsg) {
          setTimeout(() => {
            if (form.dataset.redirect) {
              window.location.href = form.dataset.redirect;
            }
          }, 1500);
        }
      } else {
        showAlert('لطفاً تمام فیلدهای الزامی را پر کنید.', 'danger');
      }
    });
  });

  // File Upload Visual
  document.querySelectorAll('.file-upload input[type="file"]').forEach(input => {
    input.addEventListener('change', function () {
      const label = this.closest('.file-upload').querySelector('.file-name');
      if (label && this.files.length) {
        label.textContent = this.files[0].name;
      }
    });
  });

  // Active Nav Link
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-menu a, .sidebar-nav a').forEach(link => {
    const href = link.getAttribute('href');
    if (href && (href === currentPage || href.endsWith(currentPage))) {
      link.classList.add('active');
    }
  });

  // Simple LocalStorage Auth Simulation
  const user = JSON.parse(localStorage.getItem('conference_user') || 'null');
  updateAuthUI(user);
});

function showAlert(message, type = 'info') {
  const existing = document.querySelector('.toast-alert');
  if (existing) existing.remove();

  const alert = document.createElement('div');
  alert.className = `alert alert-${type} toast-alert`;
  alert.style.cssText = 'position:fixed;top:20px;left:50%;transform:translateX(-50%);z-index:9999;min-width:300px;box-shadow:0 10px 25px rgba(0,0,0,0.15);';
  alert.innerHTML = `<span>${message}</span>`;
  document.body.appendChild(alert);
  setTimeout(() => alert.remove(), 3500);
}

function updateAuthUI(user) {
  const authButtons = document.querySelector('.nav-actions');
  if (!authButtons) return;
  // Auth state is handled per-page for static template
}

function loginDemo(email, role) {
  const user = {
    name: role === 'admin' ? 'مدیر سیستم' : 'کاربر نمونه',
    email: email || 'user@example.com',
    role: role || 'user'
  };
  localStorage.setItem('conference_user', JSON.stringify(user));
  showAlert('ورود موفقیت‌آمیز بود!', 'success');
  setTimeout(() => {
    if (role === 'admin') {
      window.location.href = 'admin-dashboard.html';
    } else if (role === 'reviewer') {
      window.location.href = 'reviewer-dashboard.html';
    } else {
      window.location.href = 'dashboard.html';
    }
  }, 1000);
}

function logout() {
  localStorage.removeItem('conference_user');
  showAlert('با موفقیت خارج شدید.', 'info');
  setTimeout(() => window.location.href = 'index.html', 800);
}

// Counter Animation
function animateCounters() {
  document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    let current = 0;
    const step = target / 50;
    const timer = setInterval(() => {
      current += step;
      if (current >= target) {
        el.textContent = target.toLocaleString('fa-IR');
        clearInterval(timer);
      } else {
        el.textContent = Math.floor(current).toLocaleString('fa-IR');
      }
    }, 30);
  });
}

if (document.querySelector('[data-count]')) {
  animateCounters();
}
