# Endpoint Returns a 404 Error

**Symptom:** you open a custom endpoint and see a "page not found" error.

**Cause:** custom endpoints are WordPress rewrite rules. A rule must exist before its URL works.

The plugin refreshes the rules for you. When you save the Endpoints tab and something changed, it schedules a refresh. The refresh runs on the next page load. The schedule lasts 60 seconds.

## Fix

1. Make sure you clicked **Save Changes** on the Endpoints tab after adding the item. An item that is only on screen has no URL.
2. Open any page on your site once, then try the endpoint again.
3. If it still fails, go to **Settings > Permalinks** and click **Save Changes** without changing anything. This refreshes the rules by hand.
4. Clear any page cache or CDN cache, then test again in a private window.

## Other causes

- **You changed the slug.** The old URL no longer works. Use the new URL from the menu. See [Add an endpoint](../manage-the-account-menu/02-add-an-endpoint.md).
- **You removed the item.** Its URL is gone with it.
- **Your slug matches a WooCommerce endpoint.** Pick a different slug on the item.
- **You typed the URL by hand.** Click the menu item instead and copy the address from the browser.
