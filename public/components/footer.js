class CustomFooter extends HTMLElement {
  connectedCallback() {
    this.attachShadow({ mode: 'open' });
    this.shadowRoot.innerHTML = `
      <style>
        footer {
          background: #111827;
          color: #9ca3af;
          padding: 2rem;
          text-align: center;
          border-top: 1px solid #374151;
          margin-top: auto;
        }
        .footer-content {
          max-width: 1200px;
          margin: 0 auto;
        }
      </style>
      <footer>
        <div class="footer-content">
          <p>&copy; 2024 Medilab - Riservato e Confidenziale</p>
        </div>
      </footer>
    `;
  }
}

customElements.define('custom-footer', CustomFooter);
