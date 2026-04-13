# NexaVault — Digital Asset Platform Landing Page

A modern, production-quality single-page website for a fintech/crypto platform. Built with pure HTML, CSS and JavaScript — no frameworks required.

---

## 🎨 Design System

**Color Palette: Navy + Electric Blue (Option B)**
- Background: `#020817` (deep navy)
- Primary Blue: `#3B82F6`
- Electric Cyan: `#22D3EE`
- Text: `#F1F5F9` / `#94A3B8`
- Gold Accents: `#F59E0B` (private client)

**Typography:**
- Headings: Space Grotesk (bold, modern)
- Body: Inter (clean, readable)

---

## ✅ Completed Features

### Page Sections
1. **Navbar** — Fixed, transparent → frosted glass on scroll. Active link highlighting. Mobile hamburger menu.
2. **Hero** — Full viewport with animated glow background, grid overlay, phone app mockup with live-updating balance and coin prices. Floating UI cards. Scroll ticker.
3. **Crypto Ticker** — Horizontal auto-scrolling price strip with 10 coins (BTC, ETH, SOL, BNB, XRP, ADA, AVAX, MATIC, DOT, LINK). Prices update every 5 seconds.
4. **Media Logos** — "As Featured In" strip with Forbes, Fortune, Bloomberg, NASDAQ, Business Insider, WIRED logos.
5. **Features Grid** — 6 feature cards (Security, Speed, AI Bots, Analytics, Global Reach, Multi-Asset). Hover glow effect.
6. **Invest Section** — Two-column layout: Growth/Staking card (with animated chart) + Private Client card (gold palette with pulsing rings).
7. **Security Section** — Hexagonal icon grid with animated glow + detailed security feature list.
8. **How It Works** — 3-step process cards with connectors.
9. **Testimonials** — 4 client reviews in a 2-column grid.
10. **Pricing** — 3-tier pricing table (Starter / Growth / Elite) with popular badge.
11. **CTA Section** — Email capture form with success animation + phone mockup illustration.
12. **Footer** — 5-column layout with social links, page links, legal links.
13. **Back to Top** — Floating button, appears after scrolling 400px.

### JavaScript Functionality
- Navbar scroll state change
- Mobile menu with animated hamburger
- Custom AOS (Animate on Scroll) with stagger
- Animated counter numbers in hero stats
- Live crypto price simulation (ticker + phone mockup)
- Balance animation in phone mockup
- Mini chart path animation
- Email form validation with shake + tooltip + confetti
- Magnetic button hover effect
- Feature card gradient spotlight on hover

---

## 📁 File Structure

```
index.html         ← Main single-page website
css/
  style.css        ← All styles (~37KB)
js/
  main.js          ← All interactivity (~18KB)
README.md
```

---

## 🚀 Entry Points

| Path | Description |
|------|-------------|
| `/` or `index.html` | Main landing page |
| `#features` | Features section |
| `#invest` | Investment products |
| `#security` | Security architecture |
| `#testimonials` | Client reviews |
| `#pricing` | Pricing plans |
| `#signup` | CTA / email signup |

---

## 📊 Branding

- **Brand Name:** NexaVault
- **Tagline:** "The Future of Digital Finance Starts Here"
- **Target Audience:** Retail to institutional crypto investors
- **Key USPs:** Security, AI trading bots, staking yields, private client program

---

## 🔧 Recommended Next Steps

1. **Backend Integration** — Connect email form to Mailchimp, ConvertKit or similar
2. **Live Price API** — Replace simulated prices with CoinGecko or Binance WebSocket feed
3. **Auth Pages** — Build login / register pages linked from nav CTAs
4. **TradingView Widget** — Embed real chart widget in the portfolio/invest section
5. **Blog Section** — Add news/insight articles for SEO
6. **Cookie Banner** — GDPR-compliant cookie consent
7. **Analytics** — Add Google Analytics or Plausible
8. **Dark/Light Toggle** — Optional theme switcher

---

## ⚠️ Disclaimer

> This is a demo landing page for design/development purposes. NexaVault is a fictional brand. Cryptocurrency prices shown are simulated. This website does not constitute financial advice.

---

*Built with HTML5 · CSS3 · Vanilla JavaScript | 2025*
