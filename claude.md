# Claude Code - Project Notes

This file contains important reminders and context for Claude Code when working on this project.

---

## Basecamp Integration Guidelines

### Comment Formatting
**IMPORTANT:** When posting comments or replies to Basecamp cards using the MCP Basecamp integration, always use explicit HTML `<br>` tags for line breaks instead of relying on newline characters (`\n`).

**Correct Format:**
```html
<strong>Status:</strong> Fixed<br><br>
The issue has been resolved.<br><br>
<strong>Testing instructions:</strong><br>
1. Test the feature<br>
2. Verify it works<br>
```

**Why:** Basecamp's comment system requires explicit HTML formatting for proper line break rendering. Using `\n` may not render correctly in the Basecamp UI.

**Additional HTML formatting to use:**
- `<strong>` for bold text
- `<ul><li>` for unordered lists
- `<ol><li>` for ordered lists
- `<code>` for inline code
- `<pre>` for code blocks
- `<br>` for line breaks (single break)
- `<br><br>` for paragraph breaks (double break)

---

## Project Information

**Plugin Name:** WooCommerce Custom My Account Page
**Version:** 1.4.1
**Branch:** 1.4.1
**Basecamp Project ID:** 37614349

### Key Files
- `admin/class-woo-custom-my-account-page-admin.php` - Main admin class
- `admin/partials/wcmp-endpoints-settings.php` - Endpoints management UI
- `admin/partials/endpoint-item.php` - Endpoint template
- `admin/partials/group-item.php` - Group template
- `admin/partials/link-item.php` - Link template
- `admin/partials/wcmp-faq.php` - FAQ tab content

### Recent Fixes (Session: 2025-11-11)
1. ✅ Fixed fatal error when creating groups (undefined slug/type)
2. ✅ Fixed undefined variable warnings in link-item.php
3. ✅ Fixed duplicate endpoints creation on save
4. ✅ Added comprehensive FAQ tab to admin settings

### Pending Issues
- Avatar upload blank display issue (Card: 9266167368)

---

## Development Guidelines

### Git Workflow
- Always commit changes with descriptive messages
- Include file names and line numbers in commit messages
- Add "🤖 Generated with Claude Code" footer
- Include "Co-Authored-By: Claude <noreply@anthropic.com>"

### Code Standards
- Follow WordPress coding standards
- Always use proper escaping: `esc_html()`, `esc_attr()`, `esc_url()`
- Add security checks: nonce verification, capability checks
- Use `isset()` checks before accessing array keys
- Add PHPDoc comments for all methods

---

## Notes for Future Sessions

### Testing Workflow
1. Make code changes
2. Test locally
3. Commit to git
4. Add detailed comment to Basecamp card explaining the fix
5. Move card to "Testing" column in Basecamp
6. QA team validates the fix

### Basecamp Card Movement
- Use `mcp__basecamp__basecamp_move_card` to move cards between columns
- Testing Column ID: 7421374094
- Ready for Development Column ID: 7421374091

---

*Last Updated: 2025-11-11*
