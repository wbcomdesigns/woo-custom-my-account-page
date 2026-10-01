# The [default_dashboard_content] Shortcode

The `[default_dashboard_content]` shortcode prints the standard WooCommerce dashboard panel. This is the "Hello, name" text and its account links.

## When to use it

Use it inside a custom endpoint's content when you want the built-in dashboard text next to your own content.

## Add it to an endpoint

1. Go to **WB Plugins > Woo My Account > Endpoints**.
2. Open the custom endpoint.
3. In **Endpoint content**, type your content and add `[default_dashboard_content]` where the dashboard text should appear.
4. Click **Save Changes**.

Example:

```
Welcome to your support area.

[default_dashboard_content]
```

## How it works

The shortcode loads WooCommerce's `myaccount/dashboard.php` template for the current user. It has no attributes. Your theme's copy of that template is used if it has one.

Developers can load a different template with the [`wcmp_dashboard_shortcode_template`](../developer-guide/01-filters.md) filter.

## Empty endpoints

A custom endpoint with no content already shows the default WooCommerce dashboard content. Use this shortcode only when you want your own content as well.
