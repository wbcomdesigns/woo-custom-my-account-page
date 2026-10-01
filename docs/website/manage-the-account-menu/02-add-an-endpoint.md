# Add an Endpoint

An endpoint is a new page inside My Account. It gets its own URL and, optionally, your own content.

## Add one

1. Go to **WB Plugins > Woo My Account > Endpoints**.
2. Click **Add endpoint**.
3. In the **Name** field, type the name you want customers to see, for example `My Wishlist`.
4. Click **Save** in the dialog.
5. The new item is added at the bottom of the list. Open it to set content, icon, roles and slug.
6. Click **Save Changes**.

The menu label is exactly what you typed, including capital letters, acronyms and accented letters. The plugin does not change it.

## How the URL slug is made

The plugin builds a URL slug from the name. The slug is the last part of the endpoint URL, for example `/my-account/my-wishlist/`.

| Name you type | Slug you get | Why |
|---------------|--------------|-----|
| `Uberweisungen` | `uberweisungen` | Latin names use the standard WordPress slug. |
| `My Wishlist` | `my-wishlist` | Lowercase, spaces become hyphens. |
| `Мои данные` | `moi-dannye` | Other scripts are transliterated when the PHP `intl` extension is installed on your server. |
| Any non-Latin name without `intl` | `endpoint-1` | The plugin numbers the item instead. |

Groups and links are numbered the same way, as `group-1` and `link-1`. If the number is taken, the next free number is used.

## Duplicate names

Each item needs its own slug. If the slug already exists in the list, the dialog stays open and shows:

`An item with the slug "..." already exists.`

Type a different name and click **Save** again. The dialog also shows a message if the name is empty ("This field is required.") or if the request fails ("The item could not be added. Please try again.").

## Edit the slug

You can change the slug later in the **Endpoint slug** field of the item.

1. Open the item.
2. Change **Endpoint slug**. The plugin cleans what you type into lowercase letters, numbers and hyphens.
3. Click **Save Changes**.

Keep these rules in mind:

- The slug must be unique, and must not match a WooCommerce account URL such as `view-order` or `order-pay`. If it does, saving keeps the slug the item was created with and shows a notice.
- Changing a slug changes the endpoint URL. Old bookmarks and links to the previous URL stop working.
- Leave the Dashboard slug alone. It has no slug field.
- Changing the Log out slug also changes WooCommerce's logout URL.

## Changing a default item's slug

When you change the slug of a default WooCommerce item such as Orders, the plugin also updates the matching WooCommerce endpoint option, so the URL changes everywhere on your store.

## URLs work after saving

Endpoints are WordPress rewrite rules. The plugin refreshes the rules for you after you save. If a new endpoint still returns a 404 error, see [Endpoint returns 404](../troubleshooting/01-endpoint-returns-404.md).
