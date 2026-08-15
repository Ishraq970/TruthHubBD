# 🛡️ TruthHubBD — Bangladesh Trust Layer & Review System

**TruthHubBD** is a modern community review, canonical entity discovery, and fraud prevention platform built specifically for Bangladesh. It features verified user authentication, strict 5-minute token security, structured multi-dimension reviews, and a high-performance modern stack.

---

## 📁 Repository Architecture

```text
TruthHubBD-Phase-1/
├── 🌐 frontend/                  React 19 / Next.js Web Application
│   ├── app/                      App Router entry points & styling
│   │   ├── globals.css           Design tokens & responsive styles
│   │   ├── layout.tsx            HTML head, favicon & meta definitions
│   │   └── truthhub-app.tsx      Main Single-Page App with client routing
│   ├── src/
│   │   ├── components/           Clean UI component library
│   │   │   ├── ui/BusinessCard.tsx
│   │   │   ├── ui/ComingSoonModal.tsx
│   │   │   ├── ui/DemoNotice.tsx
│   │   │   ├── ui/Logo.tsx
│   │   │   ├── ui/ReviewCard.tsx
│   │   │   ├── ui/Stars.tsx
│   │   │   ├── ui/StatusPill.tsx
│   │   │   └── ui/WriteReviewModal.tsx
│   │   ├── data/mock/            Bangladeshi business & case datasets
│   │   │   ├── businesses.ts
│   │   │   └── scamAlerts.ts
│   │   ├── features/auth/        Sanctum session-aware AuthContext
│   │   ├── services/             API services (authService, businessService)
│   │   └── types.ts              TypeScript data models & interfaces
│   └── public/                   Static icons, logos & vector favicon
│
└── ⚙️ backend/                   Laravel 12 REST API & Security Core
    ├── app/Http/Controllers/     Auth, Google OAuth & Profile controllers
    ├── app/Http/Requests/        Validation rules & sanitization
    ├── config/                   CORS, Mail & Session configuration
    ├── database/migrations/      MySQL schema definitions
    └── tests/Feature/            Automated PHPUnit authentication test suite
```

---

## ✨ Key Features

1. **Robust Authentication & Security**:
   - **Google 1-Click OAuth**: Seamless sign-in with automatic email verification.
   - **Strict 5-Minute Expiration**: Email verification links and password reset tokens automatically expire after 5 minutes.
   - **Bcrypt Password Hashing**: Passwords securely hashed and salted in MySQL.
   - **Sanctum HTTP-Only Sessions**: Protected state preventing token theft or XSS leakage.

2. **Entity Discovery & Multi-Dimension Filtering**:
   - **Real-Time Search**: Instant search matching across English & Bengali names (`স্কয়ার হাসপাতাল`, `স্টার টেক`), categories, locations, and descriptions.
   - **Category Filters**: Products, Businesses & Services, Doctors & Professionals, Hospitals & Clinics, Universities & Education, Courier & Digital Services.
   - **Rating Distribution & Star Filter**: Filter entity reviews by exact star rating (5★, 4★, 3★, 2★, 1★) or sort by newest, highest rating, and most helpful.

3. **Structured Review Submission**:
   - Canonical entity selector with instant *“Entity missing?”* stub trigger.
   - Interactive gold star rating component.
   - Image & receipt photo upload zone with instant preview.
   - Conflict of interest disclosure and optional scam alert classification.

4. **Bangladesh Trust Shield & Scam Alerts**:
   - Dedicated Scam Alerts status view.
   - Clear distinction between consumer reviews and forensic incident reports.

---

## 🚀 Quick Start Guide

### 1. Prerequisites
- **Node.js**: v20+ or v22+
- **PHP**: v8.2+ with `pdo_mysql`, `curl`, `openssl`
- **Composer**: v2+
- **MySQL**: v8+ (Database: `truthhubbd`)

---

### 2. Backend Setup (Laravel 12 API)

```bash
cd backend
cp .env.example .env

# Install dependencies & generate app key
composer install
php artisan key:generate

# Run migrations
php artisan migrate

# Start Laravel server (Port 8001)
php artisan serve --port=8001
```

Run automated backend feature tests:
```bash
php artisan test
```

---

### 3. Frontend Setup (React 19 / Next.js)

```bash
cd frontend
cp .env.example .env.local

# Install dependencies
npm install

# Start development server (Port 3000)
npm run dev
```

Run TypeScript compilation check:
```bash
npx tsc --noEmit
```

---

## 🔒 Security & Privacy Compliance
TruthHubBD is designed following the **Bangladesh Personal Data Protection Act 2026 Ready** guidelines. Unverified accounts cannot authenticate, session cookies are strictly scoped to HTTP-only domain contexts, and personal information is never exposed to unauthenticated parties.
