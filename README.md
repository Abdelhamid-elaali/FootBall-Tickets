# ⚽ FootballTix - Premium Match Ticket Booking System

FootballTix is a modern, high-performance web application built with **Laravel 11**, **Tailwind CSS**, and **Alpine.js**. It provides a seamless experience for football fans to browse matches and purchase digital tickets.

![Version](https://img.shields.io/badge/version-3.0.0-green.svg)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![Tailwind](https://img.shields.io/badge/Tailwind-3.x-blue.svg)

## 🚀 Recent Updates (v3.0.0)

We have completely overhauled the user and admin experience with a focus on modern aesthetics and premium UX.

### 💎 Modernized Admin Dashboard
- **Collapsible Sidebar:** Intelligent, space-saving sidebar with smooth transitions and persistent state via `localStorage`.
- **Aesthetic UI:** Upgraded to a sleek dark-themed navigation with glassmorphism headers and refined hover animations.
- **Enhanced Profile Management:** Rounded profile section with real-time status indicators and a compact "bubble" design.
- **Optimized List Views:** Standardized action buttons to a clean icon-only layout, reducing clutter and improving focus.

### 📑 Smart Navigation & Pagination
- **UX-First Pagination:** Brand new "smart" pagination system featuring a compact pill design, high-contrast active states, and right-aligned placement for better accessibility.
- **Interactive Feedback:** Smooth hover effects on all navigation elements to provide clear visual cues.

### 🎫 Revolutionized Ticket System
- **Premium "My Tickets" Hub:** Completely redesigned user ticket area with high-end card layouts, modern gradients, and floating badges.
- **2026 E-Ticket Experience:** A digital ticket view inspired by physical match passes, featuring "cut-out" aesthetics, technical typography, and scan-ready layouts.
- **Professional Landscape PDFs:** High-contrast, horizontal PDF ticket downloads with integrated admission stubs and official branding, perfect for printing or mobile entry.

### 🛠️ Core Features
- **Match Management:** Full CRUD for football matches with dynamic ticket type pricing (VIP, Premium, Standard).
- **Secure Booking:** Robust ticket reservation system with real-time availability tracking.
- **Payment Integration:** Ready for secure payment processing.
- **Responsive Design:** Fully optimized for mobile, tablet, and desktop viewing.

---

## 🛠️ Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Abdelhamid-elaali/FootBall-Tickets.git
   cd FootBall-Tickets
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration:**
   Update your `.env` with your database credentials, then run:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets:**
   ```bash
   npm run build
   ```

6. **Serve Application:**
   ```bash
   php artisan serve
   ```

---

## 📸 Technical Stack
- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Tailwind CSS, Alpine.js, Blade Templates
- **PDF Generation:** Barryvdh DomPDF
- **State Management:** Alpine.js + LocalStorage
- **Assets:** Vite

---

## 🤝 Contributing
Thank you for considering contributing to FootballTix! Please feel free to open issues or submit pull requests.

## 📄 License
This project is open-sourced software licensed under the [GNU GPL v3.0 license](LICENSE).
