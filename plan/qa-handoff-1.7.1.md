# QA handoff - Custom My Account Page for WooCommerce 1.7.1

Eight cards are in **Ready for Testing**. Each one below has a **code-flow** check (read the change, confirm it does what the card says on every surface it touches) and a **browser** check (reproduce as the right role, width and theme).

| | |
|---|---|
| Build under test | Batch 1: `master` @ `425e5a7` (PR #42, approved). Batch 2: branch `1.7.1` @ `4502a9d` (PR #43) |
| Version | 1.7.1 - not tagged yet; tag after QA passes |
| Fix branch for bounces | `1.7.1`, merged back by PR |
| Board | https://app.basecamp.com/5798509/buckets/37614349/card_tables/columns/7421374094 |

Code links are pinned to `425e5a7`: `https://github.com/wbcomdesigns/woo-custom-my-account-page/blob/425e5a7/<path>#L<line>`

## Setup

- **Install:** pull master or build the zip (`bash bin/build-release.sh`). Do one pass as an **update** from 1.7.0 on a site that already has endpoints, groups and links.
- **Admin:** `/wp-admin/admin.php?page=woo-custom-myaccount-page`. Tabs are `&tab=wcmp-endpoints`, `wcmp-general`, `wcmp-style`. Plain `&tab=endpoints` does **not** switch tabs.
- **Roles:** admin, a **customer**, a **subscriber**, and a logged-out window. Use a separate private window per role; switching user in one window sends admin URLs to an error page.
- **Themes:** Reign, BuddyX, BuddyX Pro (light and dark via the theme's own sun/moon toggle, never a hand-added class), Twenty Twenty-Five.
- **Widths:** 1440, 1024, 820, 768/769, 390.
- **RTL:** Settings > General > Site Language = العربية. The storefront follows the site language, not the user's profile language. Switch back after.
- **Debug:** `WP_DEBUG` + `WP_DEBUG_LOG` on; empty `wp-content/debug.log` before starting, check it after each card.
- **Cache:** hard-reload after switching builds; CSS/JS are versioned by plugin version, so a 1.7.1 rebuild can serve the old file.

---

## 1. Stale endpoint ID causes PHP notices - card 10375200530

When the saved menu order named an item that no longer existed, every My Account load raised `Undefined array key` and rendered an empty entry in the group. The "13 groups" pattern in the card was not the cause; one stale id is enough.

**Code flow**
- [ ] `includes/class-woo-custom-my-account-page-functions.php:465` prunes the decoded order before groups are built; nothing reads `$endpoints[ $child['id'] ]` unchecked.
- [ ] `wcmp_prune_endpoint_order()` at `:826` drops missing ids and lifts a missing group's surviving children one level up.
- [ ] `:474` returns the pruned order; the admin form posts it back (`admin/partials/wcmp-endpoints-settings.php`, hidden `endpoints-order` field), so a plain Save cleans stored data.
- [ ] Reach: `grep -rn "wcmp_settings_data()"` - every admin and frontend caller goes through this one method.

**Browser**
1. Endpoints: Add group, Add endpoint, drag the endpoint into the group, Save.
2. Open the child, Remove, confirm Delete, Save.
3. Customer, `/my-account/`, 1440 and 390.
4. To force the old failure, inject a stale id, then load as customer:
   ```
   wp eval '$o=get_option("wcmp_endpoints_settings");
   $r=json_decode($o["endpoints-order"],true);
   foreach($r as &$i) if($i["type"]==="group"){ $i["children"][]=["id"=>"ghost","type"=>"endpoint"]; break; }
   $o["endpoints-order"]=wp_json_encode($r);
   update_option("wcmp_endpoints_settings",$o);'
   ```

**Pass**
- [ ] No empty entry in the group; the removed item's URL returns 404.
- [ ] No plugin lines in debug.log, including with the injected id.
- [ ] After one plain Save on Endpoints, `wp option get wcmp_endpoints_settings` no longer contains `ghost`.

---

## 2. menu_style / sidebar_position accept any value - card 10375202173

The General save stored whatever was posted. Admin-only, frontend already fell back safely - hardening.

**Code flow**
- [ ] `admin/class-woo-custom-my-account-page-admin.php:777-785`: `menu_style` only sidebar/tab, `sidebar_position` only left/right; anything else falls back to `default_general_settings()`.
- [ ] `default_endpoint` is deliberately not whitelisted on save: `wcmp_settings_data()` validates it against real menu items on read. Confirm that check is still there.

**Browser**
1. General: switch Sidebar/Tab and Left/Right, Save each time, check My Account as customer.
2. In devtools change the Menu style `<option value="tab">` to `value="hacker"`, select it, Save.

**Pass**
- [ ] Valid values save and show on My Account.
- [ ] The crafted value is stored as `sidebar` (`wp option get wcmp_general_settings`).

---

## 3. Documentation link 404 - card 10375200836

Old docs-hub URL 404s; the plugin isn't on the hub. Both links now open `docs/website` in the GitHub repo.

**Code flow**
- [ ] `admin/class-woo-custom-my-account-page-admin.php:370` (Overview) and `admin/partials/wcmp-faq.php:229` (FAQ).
- [ ] `grep -rn "docs.wbcomdesigns" admin includes public README.txt` returns nothing.

**Pass**
- [ ] Overview > Documentation opens the GitHub docs in a new tab.
- [ ] FAQ > Full Documentation does the same.

---

## 4. Right sidebar squeezes content off-screen on mobile (Reign) - card 10375534330

With the sidebar on the right, Reign pushed the content off the left edge at 768px and below: the plugin forced a side-by-side row at every width, overriding Reign's stacking.

**Code flow**
- [ ] `public/assets/css/woo-custom-my-account-page-public.css:562`: `row-reverse` only inside `@media (min-width: 769px)`, matching Reign's 768px breakpoint.
- [ ] Same change in `woo-custom-my-account-page-public-rtl.css`.

**Browser** - General > Sidebar position = Right, customer.

**Pass**
- [ ] Reign at 390 and 768: menu above content, both full width, no horizontal scroll.
- [ ] Reign at 769, 1024, 1440: content left, menu right.
- [ ] Same on BuddyX, BuddyX Pro, Twenty Twenty-Five at 390 and 1440.
- [ ] Sidebar Left unchanged on every theme.

---

## 5. Save buttons share one id - card 10375534520

The three settings forms are on one page and all rendered `id="submit"`.

**Code flow**
- [ ] `admin/class-woo-custom-my-account-page-admin.php:458` and `:504`, `admin/partials/wcmp-endpoints-settings.php:101`.
- [ ] `grep -rn "#submit" admin lib` - nothing relied on the old id.

**Pass**
- [ ] Ids are `wcmp-save-general`, `wcmp-save-style`, `wcmp-save-endpoints`.
- [ ] Each tab saves with "Settings saved" and keeps its values.

Remaining duplicate ids (`_wpnonce`, `footer-thankyou`) come from WordPress core and WooCommerce.

---

## 6. Endpoints builder dialogs - card 10375573957

Enter did nothing in the Add dialog, the empty-name message vanished as it appeared, Delete was the default focus in the confirmation, and the confirmation ran off a phone screen.

**Code flow**
- [ ] `admin/assets/js/woo-custom-my-account-page-admin.js:138`: Enter triggers the dialog's own Save button (one validation path).
- [ ] `:234`: the keyup handler skips Enter, so it no longer clears the message Enter just set.
- [ ] `:288-292`: confirmation width capped to the screen; `open` focuses the last button (Cancel).

**Browser - keyboard only**
- [ ] Tab to "Add endpoint", Enter, type a name, Enter: item appears, dialog closes. Same for Add group and Add link.
- [ ] Empty name + Enter: "This field is required." stays; typing clears it.
- [ ] Escape closes the dialog; focus returns to the Add button.
- [ ] Remove on a custom item: focus on Cancel; Enter closes without deleting.
- [ ] At 390 both dialogs fit inside the screen.

---

## 7. Tab layout dropdown and aria state - card 10375574113

At 820px a group dropdown near the start edge was cut off. On phones the opener said "collapsed" while its submenu was open.

**Code flow**
- [ ] `public/assets/css/woo-custom-my-account-page-public.css:431` start-aligns the dropdown; `:439` end-aligns only the last tab. Same in the RTL sheet.
- [ ] `public/templates/wcmp-myaccount-menu-group.php:25`: in Tab layout `aria-expanded` starts false. The functions file still forces groups open for Tab layout; only the aria value changed.
- [ ] The template is theme-overridable: a theme copy in `woocommerce/` keeps the old aria behaviour. Note it, don't bounce for it.

**Browser** - General > Menu style = Tab; test with the group as the first tab and as the last tab.

**Pass**
- [ ] 820, 1024, 1440: hover the group; dropdown fully on screen, no horizontal scroll.
- [ ] 390: open "Account menu", tap the group: opens, aria-expanded true; tap again: closes, false.
- [ ] Same in RTL (Arabic) at 820 and 390.

---

## 8. Active menu item contrast - card 10375574273

On themes without an accent colour the fallback blue measured 3.9:1 for the active item (AA needs 4.5:1). New fallback `#1565c0` is 5.75:1 on white.

**Code flow**
- [ ] `public/assets/css/woo-custom-my-account-page-public.css:24-28`: `--wcmp-accent` still tries BuddyX, Reign and theme presets first; only the last fallback changed. Same in the RTL sheet.

**Pass**
- [ ] Twenty Twenty-Five, customer: active item is a deeper blue; devtools contrast checker shows AA pass.
- [ ] Reign, BuddyX, BuddyX Pro: active item colour unchanged from 1.7.0.

---

## Regression sweep (once, after the cards)

- [ ] Update from 1.7.0 on a site with groups, links and role-restricted items: menu unchanged, no notices.
- [ ] Drag an item to the top of Endpoints, Save: customer menu order matches the admin list.
- [ ] Role-restricted endpoint: customer sees and opens it; subscriber doesn't see it and the direct URL redirects to My Account; logged-out visitor gets the login form.
- [ ] Link item with "open in new tab" opens in a new tab.
- [ ] Group opener by keyboard: visible focus ring; Enter and Space both toggle.
- [ ] Admin Endpoints / General / Style at 390, 820, 1024: no horizontal scroll.
- [ ] debug.log has no plugin lines after the whole sweep.

## Other cards from this round

| Card | Status | QA action |
|---|---|---|
| 10375202603 Group submenu does not collapse | Done, refuted | Works with a real click. Reopen only with theme, width and a screen recording. |
| 10375201708 Endpoints builder label-for | Done, refuted | All 52 labels resolve. Reopen with the exact `for` value your tool reports. |
| 10375217123 Rebuild admin to match WP Stories | Scope | Design decision for Varun. Nothing to test. |
| 10375574495 Empty endpoint shows Dashboard text | Bugs, not fixed | Waiting on an owner decision. Not in 1.7.1. |
| 10375574620 Eye toggles below 40px on phones | Bugs, not fixed | Not in 1.7.1. |
| 10375574729 Dead admin JS | Bugs, not fixed | Developer-only. Not in 1.7.1. |

Not plugin bugs, don't file against WCMP:
- BuddyX: links inside WooCommerce's dashboard text are near-black with no underline (BuddyX link style).
- Arabic site: menu labels stay English because labels are stored as typed (known, in the plugin's notes).

---

# Batch 2 - admin UX audit + avatar popup (PR #43)

QA approved batch 1. Batch 2 fixes the 8 cards filed after the admin UX audit. Test on branch `1.7.1` @ `4502a9d` (PR #43). Code links: `https://github.com/wbcomdesigns/woo-custom-my-account-page/blob/4502a9d/<path>#L<line>`

Extra setup for this batch:
- **Admin colour scheme:** Users > Profile > Admin Color Scheme (Default, Sunrise, Ocean).
- **Admin RTL:** Users > Profile > Language = العربية (admin follows the user language).
- **Test images:** one small JPG/PNG, one image over 2MB, one non-image file (.txt).

## 9. Endpoints builder breaks in RTL - card 10375763246

**Code flow**
- [ ] `admin/assets/css/woo-custom-my-account-page-admin.css` uses logical properties throughout; `grep -nE "(margin|padding)-(left|right)|[^-](left|right):"` returns only `:338` area (`left: 0` on `.wcmp-dialog.ui-dialog`, documented: jQuery UI sets inline left/top).
- [ ] `.on-off-endpoint` (`:193`) uses `inset-inline-start`, `.open-options` (`:232`) uses `inset-inline-end`; nested list indent is `padding-inline-start`.

**Pass**
- [ ] Admin in Arabic, Endpoints at 1440 and 390: eye on the right, badge + arrow on the left, child rows indented from the right, no overlap with names, no horizontal scroll.
- [ ] Add and Delete dialogs read correctly in RTL.

## 10. Endpoints builder uses Dashicons - card 10375763351

**Code flow**
- [ ] `admin/partials/endpoint-item.php`, `group-item.php`, `link-item.php`: eye / chevron are `data-lucide` icons; `grep -rn dashicons admin/partials` returns nothing.
- [ ] Menu-icon preview prints `<i class="wcmp-icon-preview fa ...">` with the same `fa-` rule as `public/templates/wcmp-myaccount-menu-group.php`; `wcmp_fa_to_dashicon()` is deleted (`grep -rn fa_to_dashicon` returns nothing).
- [ ] `admin/assets/js/woo-custom-my-account-page-admin.js:191` re-runs `lucide.createIcons()` after an AJAX-added row.
- [ ] Only Dashicon left in the admin class is the WB Plugins menu icon (`add_menu_page` needs one).

**Pass**
- [ ] Endpoints icons match the sidebar's icon style; each row's preview icon matches the storefront menu icon.
- [ ] Add an endpoint: its row shows the eye and arrow before saving.

## 11. Admin CSS hard-coded colours / colour scheme - card 10375763464

**Code flow**
- [ ] Admin sheet `:20` token block on `.wbcom-admin, .wcmp-dialog` reads `--wbcom-*` (which reads `--wp-admin-theme-color`). No hex outside token definitions: `grep -nE '#[0-9a-fA-F]{3,6}' admin/assets/css/woo-custom-my-account-page-admin.css | grep -v -- '--wcmp-'` returns nothing.
- [ ] Dialogs carry `dialogClass: 'wcmp-dialog'` (admin JS `:106`, `:283`), so the tokens reach them outside the wrapper.

**Pass**
- [ ] Switch admin scheme to Sunrise and Ocean: badges, Save, dialog buttons follow; switch back to Default.
- [ ] Dialogs: one primary button; Delete is red, Cancel secondary; 40px buttons and close.

## 12. Non-standard admin breakpoints - card 10375763535

**Code flow**
- [ ] Admin sheet has exactly two width queries: `@media (max-width: 1024px)` (`:579`) and `(max-width: 640px)` (`:592`) (plus reduced-motion).

**Pass**
- [ ] Open a builder row at 390, 820, 1024: label above a full-width field. At 1025 and 1440: side by side at the shell's standard width (same as General). No horizontal scroll anywhere.

## 13. Eye toggles below 40px - card 10375574620

**Pass**
- [ ] At 390, each eye is a 40x40 tap target and toggles visibility without opening the row.
- [ ] Keyboard: Tab reaches it (visible ring), Space toggles; screen reader name "Show in menu".

## 14. Dead admin JS - card 10375574729

**Code flow**
- [ ] `grep -rn "wcmp_menu_style\|wcmp_sidebar_position_wrapper\|wcmp_option_hide" admin public includes` returns nothing.

**Pass**
- [ ] General: switching Menu style to Tab hides Sidebar position immediately, Sidebar shows it again; Save works.

## 15. Empty custom page shows Dashboard text - card 10375574495

**Code flow**
- [ ] `includes/class-woo-custom-my-account-page-functions.php:210`: only when the endpoint has no content, is not `dashboard`, and nothing hooks `woocommerce_account_{key}_endpoint`; it removes WooCommerce's default content and prints `wc_print_notice( ..., 'notice' )`. Admin link only with `manage_options`.

**Pass**
- [ ] New endpoint, empty content, saved. Customer: "There is nothing on this page yet." Admin: same + "Add content to this page" link to the Endpoints tab.
- [ ] Orders, Downloads, an endpoint with content, and the Dashboard look exactly as before.

## 16. Avatar upload popup - card 10375619453

**Code flow**
- [ ] `public/class-woo-custom-my-account-page-public.php:35`/`:42`: `AVATAR_MAX_BYTES` and `AVATAR_TYPES` constants used by the upload handler AND printed into the form (`data-max-bytes`, `data-types`, `accept`), so browser and server limits can't drift.
- [ ] `public/templates/wcmp-myaccount-avatar-form.php`: `role="dialog"`, `aria-modal`, `aria-labelledby`; file input `aria-describedby` the hint and the error; Reset form + button only when the user has `wb-wcmp-avatar` meta; buttons submit their form via the `form` attribute.
- [ ] `get_form_allowed_html()` (`:622`) allows every new attribute (the form is passed through `wp_kses`); if an attribute is missing there, it silently disappears from the popup.
- [ ] `public/assets/js/woo-custom-my-account-page-public.js`: `check_file()` (`:25`), focus trap + Escape (`:94`), `close_popup()` returns focus (`:11`). No resize/centre JS left (centred by CSS, `#wcmp-avatar-form` at public CSS `:325`).
- [ ] Primary button uses `--wcmp-btn-bg/--wcmp-btn-fg` (public CSS `:58`), which follow the theme's own button colours.

**Pass**
- [ ] Opens centred at 1440 and 390, fits the screen; focus lands on the picker; Tab stays inside; Escape closes and focus returns to the camera button.
- [ ] .txt file: type message next to the field, Upload disabled. Image over 2MB: size message, Upload disabled. Small image: preview in the circle, file name shown, Upload enabled.
- [ ] Drag an image onto the zone: same as picking it.
- [ ] Upload: "Avatar updated successfully!", new avatar in the menu. Reopen: "Reset to default" shown; Reset restores the default avatar.
- [ ] Reign, BuddyX, BuddyX Pro light + dark (theme toggle) and Twenty Twenty-Five: title, hint and Upload text readable (devtools contrast AA), 40px buttons.
- [ ] RTL (site language Arabic): mirrored, still centred.

## Batch 2 regression sweep

- [ ] Batch 1 checks 1-8 still pass on `1.7.1` @ `4502a9d` (same code paths, restyled).
- [ ] No plugin lines in debug.log after the whole pass.

## Reporting back

1. **Pass:** comment on the card with theme, width and role tested, move it to Done.
2. **Fail:** comment with exact steps, theme, width, role, a screenshot or recording and any debug.log line; move it back to Bugs. Fixes go on branch `1.7.1`.
3. When all batch 2 cards pass, say so in the Slack thread; PR #43 is merged and `v1.7.1` is tagged from master after that.
