# Market Audit: Custom My Account Page for WooCommerce

**Audit Date:** 2026-02-25
**Plugin Version:** 1.5.2
**Slug:** woo-custom-my-account-page
**Author:** Wbcom Designs
**Distribution:** wbcomdesigns.com (EDD SL SDK, self-hosted updates)
**Product URL:** https://wbcomdesigns.com/downloads/woocommerce-custom-my-account-page/

---

## 1. Plugin Feature Summary

### Current Free Features (v1.5.2)

| Feature | Status |
|---------|--------|
| Custom endpoints (add/edit/remove) with content editor | Yes |
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
| Shortcode support in endpoint content | Yes |
| WooCommerce template overrides (4 templates) | Yes |
| Developer hooks/filters | Yes |
| BuddyBoss/BuddyX theme compatibility | Yes |
| EDD SL SDK auto-updates from wbcomdesigns.com | Yes |

### Technical Profile
- **PHP lines:** ~6,100 (excluding vendor)
- **Architecture:** WordPress Plugin Boilerplate, OOP singleton
- **PHP:** 7.4+ tested on 8.2
- **WooCommerce:** 6.6+ tested on 10.x
- **WordPress:** 6.x tested on 6.9.1
- **Asset footprint:** ~17KB CSS/JS (loads only on account pages)

---

## 2. Competitive Landscape

### Direct Competitors

#### YITH WooCommerce Customize My Account Page
- **Installs:** 30,000+ (WordPress.org)
- **Rating:** 4.0/5
- **Pricing:** Free on WP.org, Pro $99.99/yr single site
- **Free version:** Reorder, rename, hide endpoints, basic icons
- **Pro:** Custom registration forms, dashboard widgets, conditional visibility, memberships integration, pre-built templates, advanced styling

**Where YITH beats us:** Volume (30K installs), dashboard widgets, conditional visibility, pre-built templates
**Where we beat YITH free:** Content editor (free), collapsible groups (unique), BuddyBoss compat, Nestable drag-drop, sidebar position toggle

#### SysBasics Customize My Account for WooCommerce
- **Installs:** 9,000 (WordPress.org)
- **Rating:** 4.0/5
- **Pricing:** Free on WP.org, Pro $49/yr single, $79/yr 5-sites
- **Free version:** Reorder, rename, icons, hide items, role restrictions, external links
- **Pro:** Content editor (locked behind paywall), avatar upload, dashboard widgets, notification badges

**Where SysBasics beats us:** Notification badges, clean freemium conversion
**Where we beat SysBasics:** Content editor for FREE (their biggest Pro feature), collapsible groups, BuddyBoss compat

#### Others
| Plugin | Installs | Price | Notes |
|--------|----------|-------|-------|
| XootiX Customize My Account | 1,000 | $39/yr Pro | Floor pricing, small |
| CITS My Account Customize | 500 | Free only | 5-star rating, tiny |
| Iconic Account Pages | Premium | $79/yr | Visual builder, no free |
| JetWoo Builder (Crocoblock) | Premium | $49-199/yr | Elementor-based |

### Market Size
- **Total WP.org installs in category:** ~43,000+
- **YITH dominance:** ~70% of free installs
- **Revenue ceiling:** YITH at $99/yr with 30K installs suggests significant conversion revenue

---

## 3. Our Competitive Advantages (Free Tier)

These are features NO competitor offers for free:

| Feature | YITH Free | SysBasics Free | Us (Free) |
|---------|:---------:|:--------------:|:---------:|
| Endpoint content editor | No | No | **Yes** |
| Collapsible menu groups | No | No | **Yes** |
| BuddyBoss/BuddyX compat | No | No | **Yes** |
| Sidebar left/right toggle | No | No | **Yes** |
| Custom avatar upload | No | No | **Yes** |
| User role restrictions | No | No | **Yes** |
| Style color pickers | No | No | **Yes (6)** |

**Positioning statement:** The only WooCommerce My Account customizer that gives store owners a content editor, collapsible groups, and BuddyBoss compatibility — all free.

---

## 4. Traffic Strategy: Drive Everything to wbcomdesigns.com

### Distribution Model
- **Free plugin** distributed exclusively from wbcomdesigns.com/downloads/
- **EDD SL SDK** handles auto-updates — users stay connected to our site
- **Every plugin install** = a registered connection back to wbcomdesigns.com for update checks
- **Pro upsell** within the plugin admin drives paid conversions

### Self-Hosted Advantages
1. **Every install phones home** — update checks = recurring traffic to wbcomdesigns.com
2. **No middleman** — we own the relationship, the data, the funnel
3. **Upsell freedom** — no WP.org guidelines restricting admin notices or Pro prompts
4. **Cross-sell opportunity** — 14 other Wbcom plugins can be promoted within the admin
5. **Email capture** — can gate download behind email (optional, for newsletter)
6. **Full analytics** — EDD tracks downloads, active installs, geographic data

### WordPress.org Cross-Promotion Funnel (Key Strategy)

**Existing WP.org presence:**
| Plugin | WP.org Status | Role in Funnel |
|--------|:---:|---|
| Document Preview for WooCommerce | **Live on WP.org** | Traffic magnet #1 |
| Audio Preview for WooCommerce | Ready to submit | Traffic magnet #2 |
| Other 9 plugins (incl. this one) | Self-hosted | Promoted via cross-sell |

**How the funnel works:**
```
WordPress.org organic search
  → User discovers Document Preview / Audio Preview (free, on WP.org)
  → Installs plugin
  → Sees "WB Plugins > Themes & Extensions" in admin sidebar
  → Browses Wbcom product cards (all 14 plugins displayed)
  → Discovers "Custom My Account Page" and other plugins
  → Clicks "View Details" → lands on wbcomdesigns.com
  → Downloads free plugin → sees Pro upsell
```

**Every WP.org plugin is a funnel entry point.** The shared `admin/wbcom/` framework already displays product cards for all Wbcom plugins in every installation. More plugins on WordPress.org = more entry points = more traffic to wbcomdesigns.com for the entire product suite.

**Action items:**
1. **Submit Audio Preview to WordPress.org** — it already has readme.txt, make it the 2nd WP.org funnel entry
2. **Consider submitting 2-3 more simple plugins** — each one is another permanent traffic source
3. **Ensure the Themes & Extensions page prominently features Custom My Account Page** — this is the highest-value cross-sell (most features for free, clear Pro upsell path)
4. **Add "Recommended" or "Popular" badge** to Custom My Account Page card in the shared admin page
5. **Track which product card gets the most clicks** — add UTM parameters to wbcomdesigns.com links in the product cards

**Projected impact:** Each WP.org plugin with 1,000+ installs generates ~50-200 admin page views/month of the Themes & Extensions page. With Document Preview already on WP.org and Audio Preview submitted, that's potentially 100-400 monthly exposures to the full Wbcom product line, at zero cost.

### Content Marketing (Primary Traffic Driver)

**Goal:** Rank for high-intent WooCommerce search queries → drive organic traffic to wbcomdesigns.com → free plugin download → Pro upsell

#### Target Keywords

**Primary (high intent):**
- "woocommerce my account page customizer" — ~1,900 searches/mo
- "customize woocommerce my account" — ~1,600 searches/mo
- "woocommerce my account custom tabs" — ~880 searches/mo
- "woocommerce my account page plugin" — ~720 searches/mo

**Long-tail (low competition, high conversion):**
- "how to add custom tab to woocommerce my account page"
- "woocommerce my account page buddyboss"
- "woocommerce my account sidebar layout"
- "woocommerce my account page for membership site"
- "woocommerce my account role based tabs"

#### Blog Content Plan (Priority Order)

**Tier 1 — Write first (highest conversion):**

1. **"Best WooCommerce My Account Plugins: YITH vs SysBasics vs Wbcom (Honest Comparison)"**
   - Target: comparison shoppers ready to install
   - Include feature comparison table (Section 3 above)
   - Be honest about competitor strengths — builds trust
   - CTA: download free from wbcomdesigns.com
   - This single post can drive 200-500 downloads/month

2. **"How to Customize the WooCommerce My Account Page (No Code Guide)"**
   - Target: "customize woocommerce my account" — 1,600/mo
   - Step-by-step tutorial using our plugin with screenshots
   - 2,500 words, include video walkthrough
   - CTA: download the plugin to follow along

3. **"How to Add Custom Tabs to WooCommerce My Account Page"**
   - Target: the #1 how-to query in this space
   - Tutorial showing endpoint creation with content editor
   - Emphasize that our free version includes what others charge for

**Tier 2 — Month 2-3:**

4. **"WooCommerce My Account Page for BuddyBoss Membership Sites"**
   - Niche but zero competition for this keyword
   - Target BuddyBoss community directly
   - Cross-promote with existing Wbcom BuddyBoss plugins

5. **"WooCommerce Customer Dashboard: Turn My Account Into a Loyalty Hub"**
   - Target: store owners focused on retention
   - Show real use cases with groups, custom endpoints, role restrictions

6. **"Role-Based WooCommerce Account Pages: Different Tabs for Different Users"**
   - Target: B2B stores, membership sites, wholesale
   - Show role restriction feature in action

**Tier 3 — Ongoing:**

7. "WooCommerce My Account Custom Endpoints: Developer Guide"
8. "WooCommerce My Account Page Design: Sidebar vs Tab Layout"
9. "WooCommerce Custom Avatar Upload for Customer Profiles"

#### YouTube Strategy
- Record 3-5 minute tutorials for each Tier 1 blog post
- "WooCommerce My Account Customization" is underserved on YouTube
- Embed in blog posts, link to download page
- YouTube descriptions link back to wbcomdesigns.com

#### Social & Community Distribution
- **BuddyBoss Facebook Group** — share BuddyBoss compatibility post (organic, not spam)
- **WooCommerce Community Slack** — be helpful, mention plugin when relevant
- **Reddit r/woocommerce** — answer questions, link to tutorial posts
- **X/Twitter** — share plugin updates, customer screenshots
- **WooCommerce Show & Tell** — submit plugin for community spotlight

### Cross-Promotion Within Wbcom Ecosystem

The plugin admin already has a "Themes & Extension" page showing other Wbcom products. Leverage this:

1. **Admin banner** — Subtle "Pro coming soon" or "Check out our other WooCommerce plugins" in the plugin settings
2. **Plugin ecosystem page** — The existing wbcom-plugins-page.php already shows all Wbcom products
3. **Email follow-up** — If download is gated behind email, send a welcome sequence featuring other free plugins
4. **Bundle pricing** — When Pro launches, offer bundles with other Wbcom Pro plugins

---

## 5. Pro Version Strategy

### Pro Features (What Users Will Pay For)

Based on competitor analysis, these drive the most conversions:

| Feature | Competitor Reference | Priority |
|---------|---------------------|----------|
| Conditional endpoint visibility (by role, order count, spend) | YITH Pro $99 | **Critical** |
| Dashboard welcome widget (order stats, spend summary) | YITH Pro, SysBasics Pro | High |
| Pre-built layout templates (5-6 designs) | Iconic $79 | High |
| Advanced styling (backgrounds, typography, borders, spacing) | YITH Pro | High |
| Notification badges on menu items | SysBasics Pro | Medium |
| Avatar upload with crop/resize | YITH Pro | Medium |
| WooCommerce Memberships integration | YITH Pro | Medium |
| WooCommerce Subscriptions integration | YITH Pro | Medium |
| Settings import/export | — | Low |

### Pricing

| Tier | Price | Sites | Key Feature |
|------|-------|-------|-------------|
| **Single** | $49/yr | 1 site | All Pro features |
| **Plus** | $99/yr | 5 sites | + Memberships/Subscriptions integration |
| **Agency** | $199/yr | 25 sites | + White-label, REST API, multisite |
| **Lifetime** | 3x annual | Same | One-time purchase option |

**Rationale:**
- $49 undercuts YITH ($99) and matches SysBasics ($49)
- $99 for 5 sites = better value than YITH's $99 for 1 site
- Lifetime option captures subscription-averse buyers and generates upfront cash

### Revenue Projections (Self-Hosted, No WP.org)

#### Conservative (Year 1)
| Metric | Value |
|--------|-------|
| Organic blog traffic to plugin page | 500-1,500/mo |
| Free downloads | 1,000-3,000/yr |
| Pro conversion rate | 3-5% |
| Pro customers | 30-150 |
| Average revenue per customer | $69 |
| **Annual Revenue** | **$2,070 - $10,350** |

#### With Content Marketing Momentum (Year 2)
| Metric | Value |
|--------|-------|
| Organic traffic | 2,000-5,000/mo |
| Free downloads | 3,000-8,000/yr |
| Pro conversion rate | 4-6% |
| Pro customers | 120-480 |
| Average revenue per customer | $79 |
| Renewal rate | 60% |
| **Annual Revenue** | **$9,480 - $37,920** |

#### Established (Year 3+)
| Metric | Value |
|--------|-------|
| Monthly traffic | 5,000-15,000/mo |
| Active free installs | 5,000-15,000 |
| Pro conversion | 5-7% |
| Pro customers | 250-1,050 |
| Average revenue | $89 |
| **Annual Revenue** | **$22,250 - $93,450** |

---

## 6. Feature Roadmap

### Phase 1: Free Plugin Polish (Current — v1.5.2) ✅
- Security hardening, WPCS compliance
- Code flow fixes, dead code removal
- EDD SL SDK integration for self-hosted updates
- Distribution zip ready

### Phase 2: Content & Traffic (Weeks 1-4)
1. Write comparison blog post (YITH vs SysBasics vs Wbcom)
2. Write "How to Customize WooCommerce My Account" tutorial
3. Create 5 high-quality screenshots for product page
4. Record YouTube walkthrough (3-5 min)
5. Update wbcomdesigns.com product page with feature comparison table
6. Set up email capture on download page

### Phase 3: Pro Development (Weeks 4-10)
1. Build conditional endpoint visibility (role, order count, total spent)
2. Build dashboard welcome widget (include basic version in free)
3. Build 5 pre-built layout templates
4. Build advanced styling panel
5. Set up EDD license verification for Pro
6. Add tasteful Pro upsell in free plugin admin (lock icons on Pro features)

### Phase 4: Pro Launch (Weeks 10-12)
1. Launch Pro at $49/yr with 20% early-bird discount
2. Email wbcomdesigns.com existing customer list
3. Publish all Tier 1 blog content
4. Share in BuddyBoss community
5. Add Pro vs Free comparison on product page

### Phase 5: Growth (Month 4-12)
1. Build notification badges feature
2. Build WooCommerce Memberships integration
3. Build WooCommerce Subscriptions integration
4. Write Tier 2 and 3 blog content
5. Pursue BuddyBoss marketplace listing
6. Bundle with other Wbcom Pro plugins

---

## 7. SWOT Analysis

### Strengths
1. Most feature-rich free version in the market (content editor + groups + avatars + roles)
2. Clean, modern codebase (PHPCS, PHP 8.2, proper security)
3. BuddyBoss/BuddyX compatibility — zero competition in this niche
4. Part of 14-plugin Wbcom ecosystem — cross-promotion built in
5. EDD infrastructure ready for Pro licensing
6. Lightweight (17KB assets, loads only on account pages)

### Weaknesses
1. No organic WordPress.org traffic (intentional — self-hosted strategy)
2. No Pro version yet (revenue = $0)
3. Limited style options (6 color pickers vs competitors' full customizers)
4. No pre-built templates (higher setup friction)
5. No dashboard widgets (YITH Pro's most requested feature)
6. Plugin name competes with identically-named plugins

### Opportunities
1. Content marketing on high-intent WooCommerce queries (1,900+ searches/mo)
2. Pro launch with EDD infrastructure already built
3. BuddyBoss community as a niche distribution channel
4. Cross-sell from existing 14 Wbcom free plugins
5. First-mover on conditional visibility in free tier ecosystem
6. YouTube tutorials (underserved for this topic)

### Threats
1. YITH's install volume creates discovery flywheel
2. WooCommerce may improve My Account natively
3. Page builders (Elementor/Bricks) adding account page customization
4. Free tier commoditization — basic features available in 5+ plugins

---

## 8. Comparison Table (Use on Product Page & Blog Posts)

| Feature | Wbcom (Free) | YITH (Free) | SysBasics (Free) | SysBasics Pro ($49) | YITH Pro ($99) |
|---------|:---:|:---:|:---:|:---:|:---:|
| Add custom endpoints | Yes | Yes | Yes | Yes | Yes |
| Reorder/rename menu items | Yes | Yes | Yes | Yes | Yes |
| Hide default WC endpoints | Yes | Yes | Yes | Yes | Yes |
| **Endpoint content editor** | **Yes** | No | No | Yes | Yes |
| **Collapsible groups** | **Yes** | No | No | No | No |
| External link endpoints | Yes | No | Yes | Yes | Yes |
| Drag-and-drop reordering | Yes | Yes | Basic | Basic | Yes |
| **User role restrictions** | **Yes** | No | No | Yes | Yes |
| **Custom avatar upload** | **Yes** | No | No | No | Yes |
| Font Awesome icons | Yes | Partial | Yes | Yes | Yes |
| Sidebar + tab layouts | Yes | Yes | No | No | Yes |
| **Sidebar left/right toggle** | **Yes** | No | No | No | No |
| **Style color pickers** | **6** | No | No | Yes | Yes |
| **BuddyBoss/BuddyX compat** | **Yes** | No | No | No | No |
| Dashboard widgets | No | No | No | No | Yes |
| Conditional visibility | No | No | No | No | Yes |
| Pre-built templates | No | No | No | No | Yes |
| Self-hosted updates | Yes | N/A | N/A | N/A | N/A |
| **Price** | **Free** | Free | Free | $49/yr | $99/yr |

---

## 9. Priority Score

| Criterion | Score (1-10) | Weight | Weighted |
|-----------|:-----------:|:------:|:--------:|
| Market size and demand | 8 | 20% | 1.60 |
| Competitive advantage (free tier) | 8 | 15% | 1.20 |
| Technical readiness | 9 | 15% | 1.35 |
| Revenue potential (self-hosted) | 6 | 20% | 1.20 |
| Development effort for Pro | 6 | 15% | 0.90 |
| Strategic fit (Wbcom ecosystem) | 8 | 15% | 1.20 |
| **Overall Priority Score** | | | **7.45 / 10** |

---

*Generated: 2026-02-25 | Plugin Version: 1.5.2*
