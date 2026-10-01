# Endpoint Shows the Default Dashboard Content

**Symptom:** a custom endpoint opens, but it shows the WooCommerce dashboard text ("Hello, name") instead of your content.

**Cause:** the plugin has no content to print for that visitor, so WooCommerce falls back to its default dashboard.

## Check these

1. **Is the content empty?** An empty **Endpoint content** field shows the dashboard text. Add content and save.
2. **Is the item hidden?** A hidden item prints no content. Show it again with the eye icon and save.
3. **Is the item restricted to roles?** Visitors whose role is not in **Visible to roles** see the dashboard text. Check the roles, or log in as a user with one of them. If the item sits in a group, check the group's roles too.
4. **Was the content removed by filtering?** The plugin filters the stored content like post content. Tags such as `<script>`, `<iframe>`, `<form>` and `<input>` are removed. If the content was only those tags, nothing is left. Use a shortcode for forms and embeds.
5. **Is the shortcode plugin active?** A shortcode from an inactive plugin prints as plain text or nothing.

## If you want the dashboard text on purpose

Add `[default_dashboard_content]` to the content. See [The default dashboard shortcode](../shortcodes-and-blocks/03-default-dashboard-content-shortcode.md).
