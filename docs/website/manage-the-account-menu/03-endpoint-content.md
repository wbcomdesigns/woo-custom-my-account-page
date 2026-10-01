# Endpoint Content

Custom endpoints have an **Endpoint content** editor. Default WooCommerce items do not, because WooCommerce shows their own content.

## Add content

1. Open the custom endpoint on the **Endpoints** tab.
2. Write in **Endpoint content**. The editor is the standard WordPress editor with media upload.
3. Click **Save Changes**.

## What you can put in the content

- Formatted text, images and links.
- Shortcodes from other plugins, for example a form shortcode.
- The `[default_dashboard_content]` shortcode, to show the WooCommerce dashboard text. See [Default dashboard shortcode](../shortcodes-and-blocks/03-default-dashboard-content-shortcode.md).

Line breaks and paragraphs are kept.

## Content is filtered

The content is cleaned the same way WordPress cleans post content.

- When you save, users without the `unfiltered_html` capability have their content filtered. Users with that capability keep their markup.
- When a customer views the page, the stored content is filtered again before shortcodes run. Tags that post content does not allow, such as `<script>`, `<iframe>`, `<form>` and `<input>`, are removed from what you typed.
- Output created by a shortcode is not filtered by this plugin. A form plugin's shortcode can still show its fields.

To embed a form, use the form plugin's shortcode instead of pasting HTML.

## Empty content

If **Endpoint content** is empty, the endpoint shows the default WooCommerce dashboard content instead of a blank page. Add content to make the page your own.

## Who can see the content

A customer must be logged in to see any account page. If you restrict a custom endpoint to roles, other users do not get the content. They see the default dashboard content instead. See [Restrict items by user role](07-restrict-by-user-role.md).
