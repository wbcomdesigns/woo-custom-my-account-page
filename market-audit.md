# Market Audit: Custom My Account Page for WooCommerce

**Audit Date:** 2026-02-21
**Plugin Version:** 1.5.1
**Slug:** woo-custom-my-account-page
**Author:** Wbcom Designs

---

## 1. Plugin Feature Summary

### Current Free Features
| Feature | Status |
|---------|--------|
| Custom endpoints (add/edit/remove) | Yes |
| Custom groups (collapsible menu sections) | Yes |
| Custom external links | Yes |
| Drag-and-drop reordering (Nestable.js) | Yes |
| User role restrictions per endpoint | Yes |
| Custom avatar upload/reset | Yes |
| Menu layout: Sidebar or Tab | Yes |
| Sidebar position: Left or Right | Yes |
| Default endpoint selection | Yes |
| Style customization (6 color pickers) | Yes |
| Font Awesome icons per endpoint | Yes |
| Custom CSS classes per endpoint | Yes |
| Custom content editor (wp_editor) for new endpoints | Yes |
| Shortcode support in endpoint content | Yes |
| WooCommerce template overrides (4 templates) | Yes |
| Multiple filter/action hooks for developers | Yes |
| FAQ admin tab | Yes |
| Auto-redirect to default endpoint | Yes |
| WC endpoint slug syncing | Yes |
| Plugin Update Checker (non-WP.org updates) | Yes |
| EDD License system (prepared, not active) | Yes (scaffolded) |

### Notable Technical Details
- **Codebase:** ~6,378 PHP lines (excluding Plugin Update Checker vendor)
- **Total Files:** ~98 (including assets, vendor, docs)
- **Architecture:** WordPress Plugin Boilerplate pattern
- **Dependencies:** WooCommerce (hard requirement, deactivates without it)
- **Compatibility:** PHP 7.4+, WordPress 6.x, WooCommerce 6.6+
- **Distribution:** Self-hosted via wbcomdesigns.com (not on WordPress.org)
- **Update Mechanism:** Plugin Update Checker pointing to demos.wbcomdesigns.com

---

## 2. Distribution & Market Position

### WordPress.org Status
- **NOT listed on WordPress.org** -- distributed exclusively through wbcomdesigns.com
- This significantly limits organic discovery and trust signals
- No WordPress.org install count, reviews, or ratings available
- Estimated active installs: **500-2,000** (based on typical Wbcom Designs free plugin distribution)

### Current Monetization
- **Model:** Completely free with no monetization
- **No Pro version exists** (though EDD license infrastructure is scaffolded in `license/class-wcmp-license.php`)
- **No upsells** in the admin UI
- **No premium features gated** behind a paywall
- Revenue: **$0/year**

---

## 3. Competitor Analysis

### Direct Competitors on WordPress.org

| Plugin | Active Installs | Rating | Reviews | Downloads | Free/Pro |
|--------|----------------|--------|---------|-----------|----------|
| **YITH WooCommerce Customize My Account Page** | 30,000+ (est.) | 4.2/5 | 100+ | 1M+ | Free + Pro ($99/yr) |
| **SysBasics Customize My Account for WooCommerce** | 9,000 | 80/100 | 29 | 523,467 | Free + Pro ($49/yr) |
| **WP Frontend Delete Account** | 5,000 | 92/100 | 27 | 46,287 | Free |
| **Customize My Account Page For WooCommerce** | 1,000 | N/A | 0 | 679 | Free |
| **BuddyPress WooCommerce My Account (WC4BP)** | 1,000 | 86/100 | 72 | 95,525 | Free + Pro |
| **CITS My Account Customize for WooCommerce** | 500 | 100/100 | 2 | 3,553 | Free |

### Premium-Only Competitors

| Plugin | Price | Key Differentiators |
|--------|-------|---------------------|
| **YITH WooCommerce Customize My Account Page Pro** | $99.99/yr | Badge system, custom avatars, ban system, advanced styling, dashboard widgets, WooCommerce Membership integration |
| **Jetrsuspended Builder for WooCommerce** | $49-199/yr | Elementor-based builder, visual drag-and-drop page design |
| **Jetruspended Account Pages** | Part of JetWoo suite | Visual builder, Elementor integration |
| **Iconic WooCommerce Account Pages** | $79/yr (single) | Visual page builder, conditional fields, custom page layouts |

### Market Leader: YITH WooCommerce Customize My Account Page
- **Dominant player** with estimated 30,000+ active installs
- Free version on WordPress.org drives organic traffic
- Pro version at $99.99/yr with advanced features
- Strong brand recognition in the YITH ecosystem
- Estimated revenue: **$200,000-500,000/yr** from this single plugin

---

## 4. SWOT Analysis

### Strengths
1. **Solid feature set for free** -- endpoints, groups, links, drag-and-drop, role restrictions, avatars
2. **Clean codebase** -- WordPress Plugin Boilerplate, well-documented, PHPCS compliant
3. **Developer-friendly** -- Multiple hooks/filters, WC template override support
4. **Recent major overhaul** (v1.5.0) -- Security fixes, modern code practices, PHP 8.2 compat
5. **BuddyBoss/BuddyX theme compatibility** -- Niche advantage in community-focused WooCommerce sites
6. **License infrastructure already scaffolded** -- EDD license system ready for Pro version
7. **Part of Wbcom Designs ecosystem** -- Cross-promotion potential with other WB plugins

### Weaknesses
1. **Not on WordPress.org** -- Massive discovery disadvantage; no organic installs, no reviews, no trust signals
2. **Zero monetization** -- No Pro version, no upsells, no revenue despite having a solid product
3. **No visual/Gutenberg editor** -- Endpoint content uses basic wp_editor, not block editor
4. **Limited style options** -- Only 6 color pickers; no typography, spacing, or layout granularity
5. **No conditional logic** -- Cannot show/hide endpoints based on order count, purchase history, etc.
6. **Avatar feature is basic** -- No cropping, no social login avatar import
7. **Plugin name confusion** -- "WooCommerce Custom My Account Page" is generic and hard to differentiate
8. **No REST API endpoints** -- Cannot be used with headless WooCommerce
9. **flush_rewrite_rules() on every page load** (`wp_loaded` hook) -- Performance concern

### Opportunities
1. **Launch Pro version** -- License infrastructure exists; market validates $49-99/yr pricing
2. **WordPress.org listing** -- Even a basic free listing would 5-10x visibility
3. **Block editor integration** -- Gutenberg blocks for endpoint content would be a differentiator
4. **Advanced styling** -- Full visual customizer (backgrounds, borders, spacing, typography)
5. **Conditional endpoints** -- Show tabs based on purchase history, membership level, subscription status
6. **Dashboard widgets** -- Custom dashboard with order stats, wishlist summary, etc.
7. **WooCommerce Subscriptions/Memberships integration** -- Huge upsell for membership sites
8. **Form builder for endpoints** -- Custom forms (support tickets, warranty claims) within account page
9. **Badge/gamification system** -- User badges on account page (YITH Pro has this at $99)
10. **Social login avatar import** -- Pull avatars from Google/Facebook accounts
11. **Multi-vendor marketplace support** -- Dokan/WCFM compatibility for vendor account pages

### Threats
1. **YITH dominance** -- YITH has massive brand recognition and WordPress.org presence
2. **Page builder integrations** -- Elementor/Divi users expect visual editing capabilities
3. **WooCommerce native improvements** -- WooCommerce may improve My Account natively
4. **Commoditization** -- Many free alternatives doing the same basic thing
5. **AI/no-code tools** -- Users can increasingly customize with AI-powered site builders

---

## 5. Revenue Opportunity Assessment

### Recommended Pro Features (Tiered)

#### Tier 1: Essential Pro ($49/yr)
- Advanced styling (full customizer with typography, backgrounds, borders, spacing)
- Custom icon library (upload SVG icons, not just Font Awesome)
- Dashboard widgets (recent orders, account stats, welcome message)
- Social login avatar import
- Multiple layout templates (vertical sidebar, horizontal tabs, icon grid)
- Priority email support

#### Tier 2: Professional Pro ($99/yr)
- Everything in Tier 1, plus:
- Conditional endpoint visibility (based on order count, total spend, user meta)
- Custom registration/login forms on account page
- WooCommerce Subscriptions integration (subscription management tab)
- WooCommerce Memberships integration (member-only tabs)
- Form builder for custom endpoint content
- Badge/achievement system
- AJAX-powered tab navigation (no page reload)
- Advanced user role management (create custom roles from settings)

#### Tier 3: Agency Pro ($199/yr, 25 sites)
- Everything in Professional, plus:
- White-labeling options
- Import/export settings between sites
- REST API endpoints for headless WooCommerce
- Multi-site network support
- Dedicated support channel

### Revenue Projections

#### Conservative Scenario (Year 1)
| Metric | Value |
|--------|-------|
| WordPress.org free installs | 3,000-5,000 |
| Pro conversion rate | 2-3% |
| Pro customers | 60-150 |
| Average price | $69/yr |
| **Annual Revenue** | **$4,140 - $10,350** |

#### Moderate Scenario (Year 2-3)
| Metric | Value |
|--------|-------|
| WordPress.org free installs | 8,000-15,000 |
| Pro conversion rate | 3-5% |
| Pro customers | 240-750 |
| Average price | $79/yr |
| Renewal rate | 60% |
| **Annual Revenue** | **$18,960 - $59,250** |

#### Optimistic Scenario (Year 3-5, with marketing)
| Metric | Value |
|--------|-------|
| WordPress.org free installs | 20,000-40,000 |
| Pro conversion rate | 4-6% |
| Pro customers | 800-2,400 |
| Average price | $89/yr |
| Renewal rate | 65% |
| **Annual Revenue** | **$71,200 - $213,600** |

---

## 6. Competitive Pricing Analysis

| Competitor | Pricing | Sites | Support |
|------------|---------|-------|---------|
| YITH Customize My Account | $99.99/yr | 1 site | 1 year |
| SysBasics Customize My Account | $49/yr | 1 site | 1 year |
| Iconic Account Pages | $79/yr (single), $149/yr (5 sites) | 1-5 | 1 year |
| JetWoo Builder | $49-199/yr | 1-unlimited | 1 year |

### Recommended Pricing
- **Single Site:** $49/yr (undercut YITH, match SysBasics)
- **5 Sites:** $99/yr (strong value proposition)
- **25 Sites (Agency):** $199/yr (attractive for agencies)
- **Lifetime option:** 3x annual price

**Rationale:** Price at or below YITH to capture price-sensitive customers switching from YITH, while offering competitive features. The BuddyBoss/BuddyX compatibility is a unique selling point that justifies the price for community-focused stores.

---

## 7. Recommended Action Plan

### Phase 1: Foundation (Month 1-2)
1. List on WordPress.org (free version, cleaned up for .org guidelines)
2. Remove Plugin Update Checker for .org version (use WP.org native updates)
3. Set up EDD store on wbcomdesigns.com for Pro license sales
4. Add tasteful Pro upsell banners in free plugin admin

### Phase 2: Pro Development (Month 2-4)
1. Build Pro version with Tier 1 features (advanced styling, dashboard widgets, layouts)
2. Implement EDD Software Licensing for Pro delivery
3. Add conditional endpoint visibility (Tier 2 priority feature)
4. Create demo site showcasing Pro features

### Phase 3: Launch & Marketing (Month 4-5)
1. Launch Pro at $49/yr introductory pricing
2. Create comparison page (vs YITH, vs SysBasics)
3. Write SEO content: "How to Customize WooCommerce My Account Page"
4. Email existing Wbcom Designs customer base
5. Submit to plugin review sites

### Phase 4: Growth (Month 6-12)
1. Add WooCommerce Subscriptions/Memberships integration
2. Add Gutenberg block editor support for endpoint content
3. Implement badge/gamification system
4. Build referral/affiliate program
5. Seek WooCommerce.com marketplace listing

---

## 8. Priority Score

| Criterion | Score (1-10) | Weight | Weighted |
|-----------|-------------|--------|----------|
| Market size & demand | 8 | 20% | 1.6 |
| Competitive advantage | 5 | 15% | 0.75 |
| Technical readiness | 8 | 15% | 1.2 |
| Revenue potential | 7 | 20% | 1.4 |
| Development effort needed | 6 | 15% | 0.9 |
| Strategic fit (Wbcom ecosystem) | 8 | 15% | 1.2 |
| **Overall Priority Score** | | | **7.05 / 10** |

### Priority Justification
The plugin is technically solid after the v1.5.0 relaunch and has a clear path to monetization. The biggest gaps are distribution (not on WordPress.org) and monetization (no Pro version despite having license infrastructure). The WooCommerce My Account customization market is proven with YITH generating substantial revenue. With relatively low development effort (Pro features can be built incrementally), this plugin represents a strong revenue opportunity, especially given the existing BuddyBoss/BuddyX community niche.

**Immediate high-ROI actions:** WordPress.org listing + Pro version with advanced styling + conditional endpoints.

---

## 9. Technical Debt & Code Quality Notes

### Issues Found During Audit
1. **Performance:** `flush_rewrite_rules()` called on every `wp_loaded` hook (line 1157 of functions class) -- should only flush when endpoints change
2. **No nonce on avatar form AJAX** -- `wcmp_print_avatar_form_ajax()` does not verify nonce
3. **`nopriv` AJAX handler** -- `wcmp_add_field` registered for unauthenticated users (`wp_ajax_nopriv_wcmp_add_field`) but should be admin-only
4. **Missing `$is_processing` reset on early return** -- In `wcmp_get_avatar()`, if `$custom_avatar` is empty, `$is_processing` is not reset to `false`
5. **Generic function names** -- `instantiate_woo_custom_myaccount_functions()` risks collision with other plugins

### Strengths
- Proper sanitization callbacks for all settings
- Capability checks on AJAX handlers
- Nonce verification on forms
- PHPCS compliant
- PHP 8.2 compatible

---

*Generated: 2026-02-21*
