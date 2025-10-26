class CustomNavbar extends HTMLElement {
  connectedCallback() {
    this.attachShadow({ mode: 'open' });
    this.shadowRoot.innerHTML = `
      <style>
        nav {
          background: #1f2937;
          border-bottom: 1px solid #374151;
          padding: 1rem 2rem;
          display: flex;
          justify-content: space-between;
          align-items: center;
          backdrop-filter: blur(10px);
        }
        .logo {
          color: white;
          font-weight: bold;
          font-size: 1.5rem;
          display: flex;
          align-items: center;
          gap: 0.5rem;
        }
        .user-menu {
          display: flex;
          align-items: center;
          gap: 1rem;
          color: white;
        }
        .user-info {
          display: flex;
          align-items: center;
          gap: 0.5rem;
        }
        .logout-btn {
          background: #dc2626;
          color: white;
          border: none;
          padding: 0.5rem 1rem;
          border-radius: 0.375rem;
          cursor: pointer;
          transition: all 0.2s;
          font-size: 0.875rem;
        }
        .logout-btn:hover {
          background: #b91c1c;
          transform: scale(1.05);
        }
        @media (max-width: 768px) {
          nav {
            padding: 1rem;
          }
          .logo {
            font-size: 1.25rem;
          }
        }
      </style>
      <nav>
        <div class="logo">
          <i data-feather="activity"></i>
          Medilab
        </div>
        <div class="user-menu">
          <div class="user-info">
            <i data-feather="user"></i>
            <span>Dr. Rossi</span>
          </div>
          <button class="logout-btn" onclick="auth.logout()">
            <i data-feather="log-out"></i>
            Logout
          </button>
        </div>
      </nav>
    `;

    // Initialize Feather icons in shadow DOM
    setTimeout(() => {
      if (window.feather) {
        window.feather.replace({ class: 'feather' });
      }
    }, 100);
  }
}

customElements.define('custom-navbar', CustomNavbar);
