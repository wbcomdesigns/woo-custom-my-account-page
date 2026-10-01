# The Custom My Account Block

The **Custom My Account** block (`wcmp/my-account`) places the full My Account portal in the block editor. It does the same job as the [`[wcmp_my_account]` shortcode](01-wcmp-my-account-shortcode.md).

## Add the block

1. Edit the page in the block editor.
2. Click the **+** inserter and search for `Custom My Account`.
3. Insert the block. It is in the **WooCommerce** category.
4. Update the page.

The editor shows a server-side preview of the portal.

## Block details

| Item | Value |
|------|-------|
| Name | `wcmp/my-account` |
| Title | Custom My Account |
| Category | WooCommerce |
| Alignment | Wide and full |
| Uses per page | One. The block cannot be added twice to the same page. |
| Settings | None |

## How it works

On the front end, the block runs WooCommerce's `[woocommerce_my_account]` shortcode. The plugin's menu replaces the standard menu there. You do not need the classic shortcode text in the page content.

## Related

- [Block theme troubleshooting](../troubleshooting/04-block-theme-my-account.md)
