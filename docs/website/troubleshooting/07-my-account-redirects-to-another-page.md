# My Account Opens a Different Page

**Symptom:** a logged-in customer opens My Account, or clicks Dashboard, and lands on another page such as Orders.

**Cause:** this is the default endpoint setting working as designed.

## Fix

1. Go to **WB Plugins > Woo My Account > General**.
2. Set **Default endpoint** to **Dashboard**.
3. Click **Save Changes**.

With Dashboard as the default, no redirect happens.

## Why Dashboard also redirects

The Dashboard menu item points to the main My Account address. That address redirects to the default endpoint, so with another default the Dashboard item leads there too.

## Keep the redirect but skip it in some cases

Developers can use these filters:

- `wcmp_no_redirect_to_default` returns `true` to switch the redirect off.
- `wcmp_default_endpoint` changes the target.

See [Filters](../developer-guide/01-filters.md).

## Redirect not happening

The redirect runs only for logged-in customers on the main My Account address. It is skipped when the default endpoint is limited to a role the customer does not have, and in Elementor preview mode.
