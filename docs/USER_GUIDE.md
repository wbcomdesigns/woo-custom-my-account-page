# WooCommerce Custom My Account Page - User Guide

## Table of Contents
1. [Installation](#installation)
2. [Getting Started](#getting-started)
3. [General Settings](#general-settings)
4. [Style Customization](#style-customization)
5. [Managing Endpoints](#managing-endpoints)
6. [Creating Groups](#creating-groups)
7. [Adding External Links](#adding-external-links)
8. [User Roles & Restrictions](#user-roles--restrictions)
9. [Avatar Management](#avatar-management)
10. [Troubleshooting](#troubleshooting)

---

## Installation

### Requirements
- WordPress 5.0 or higher
- WooCommerce 3.0 or higher
- PHP 7.0 or higher

### Installation Steps
1. **Download** the plugin ZIP file
2. Navigate to **WordPress Admin → Plugins → Add New**
3. Click **Upload Plugin** and select the ZIP file
4. Click **Install Now** and then **Activate**
5. Ensure WooCommerce is installed and activated first

---

## Getting Started

After activation, navigate to **WB Plugins → Woo My Account** in your WordPress admin panel.

You'll see four main tabs:
- **Welcome** - Overview and quick links
- **General** - Basic settings
- **Style Options** - Appearance customization
- **Endpoints** - Manage account pages

---

## General Settings

### Available Options

#### Show Avatar
- **Enable/Disable** user avatar display in My Account menu
- Default: Enabled

#### Avatar Size
- Set the avatar display size in pixels
- Range: 20px to 500px
- Default: 120px

#### Show Username
- **Display/Hide** the logged-in user's name
- Default: Enabled

#### Show Logout Link
- **Display/Hide** the logout link in the menu
- Default: Enabled

#### Default Endpoint
- Select which page loads by default when users visit My Account
- Options: Any active endpoint
- Default: Dashboard

### How to Configure
1. Go to **General** tab
2. Adjust settings as needed
3. Click **Save Settings**

---

## Style Customization

### Color Options

#### Background Color
- Sets the main background color of My Account area
- Use color picker or enter hex code

#### Menu Background Color
- Sets the sidebar/tab menu background
- Default: #f5f5f5

#### Text Color
- Main text color for content area
- Default: #333333

#### Text Hover Color
- Color when hovering over links
- Default: #0073aa

#### Menu Text Color
- Text color for menu items
- Default: #333333

#### Menu Text Hover Color
- Menu text color on hover
- Default: #0073aa

### Layout Options

#### Menu Position
- **Left** - Sidebar on the left (default)
- **Right** - Sidebar on the right

#### Menu Style
- **Sidebar** - Vertical navigation menu
- **Tab** - Horizontal tab navigation

### How to Customize
1. Navigate to **Style Options** tab
2. Click on color fields to open color picker
3. Select menu position and style
4. Click **Save Settings**
5. Preview changes on the frontend

---

## Managing Endpoints

Endpoints are the individual pages within My Account (Orders, Downloads, Addresses, etc.)

### Default WooCommerce Endpoints
- Dashboard
- Orders
- Downloads
- Addresses
- Payment methods
- Account details
- Logout

### Creating Custom Endpoints

1. Go to **Endpoints** tab
2. Click **Add New Endpoint** button
3. Fill in the details:
   - **Label** - Display name in menu
   - **Slug** - URL slug (e.g., 'my-custom-page')
   - **Icon** - Font Awesome icon class (e.g., 'fa-star')
   - **Content** - Page content (supports HTML and shortcodes)
4. Click **Save Settings**

### Editing Endpoints

1. Click the **dropdown arrow** on any endpoint
2. Modify the fields:
   - Change label, slug, icon, or content
   - Set CSS classes for styling
   - Configure user role restrictions
3. Click **Save Settings**

### Enabling/Disabling Endpoints

- Click the **power button** icon to toggle endpoint visibility
- Gray = Disabled, Blue = Enabled
- Disabled endpoints won't appear in the menu

### Reordering Endpoints

1. **Drag and drop** endpoints to reorder
2. The order in admin reflects the frontend menu order
3. Click **Save Settings** to persist changes

### Deleting Endpoints

1. Click the **trash icon** on the endpoint
2. Confirm deletion when prompted
3. Click **Save Settings**

**Note:** Default WooCommerce endpoints cannot be deleted, only disabled.

---

## Creating Groups

Groups allow you to organize related endpoints under collapsible menu sections.

### How to Create a Group

1. Click **Add New Group** button
2. Configure group settings:
   - **Label** - Group name displayed in menu
   - **Icon** - Optional Font Awesome icon
   - **CSS Class** - For custom styling
3. **Drag endpoints** into the group
4. Click **Save Settings**

### Managing Group Items

- Drag endpoints in/out of groups
- Groups can be collapsed/expanded in frontend
- Empty groups are automatically hidden

### Group Limitations

- Groups cannot be nested within other groups
- Maximum 10 items per group recommended
- Groups can be reordered like endpoints

---

## Adding External Links

Add links to external websites or other WordPress pages in the My Account menu.

### How to Add External Links

1. Click **Add New Link** button
2. Fill in the details:
   - **Label** - Link text
   - **URL** - Full URL including https://
   - **Icon** - Optional icon
   - **Open in new tab** - Check if needed
3. Click **Save Settings**

### Supported URL Types

- External websites: `https://example.com`
- Internal pages: `/contact-us`
- Anchors: `#section`
- Mailto: `mailto:support@example.com`
- Tel: `tel:+1234567890`

---

## User Roles & Restrictions

Control which user roles can see specific endpoints.

### Setting Role Restrictions

1. Open endpoint/group/link settings
2. Find **User Roles** field
3. Select roles that should see this item
4. Leave empty to show to all logged-in users
5. Click **Save Settings**

### Available Roles

- Administrator
- Shop Manager
- Customer
- Subscriber
- Custom roles (if any)

### Use Cases

- **VIP Content** - Show only to specific membership roles
- **Wholesale** - Display wholesale pricing to dealers
- **Staff Only** - Internal pages for shop managers
- **Subscription** - Premium content for subscribers

---

## Avatar Management

Allow customers to upload custom profile pictures.

### For Customers

#### Uploading an Avatar
1. Go to **My Account** page
2. Click the **camera icon** on current avatar
3. Select an image file (JPG, PNG, GIF, WebP)
4. Maximum file size: 2MB
5. Recommended dimensions: 200x200px
6. Click **Upload**

#### Removing Avatar
1. Click the camera icon
2. Select **Reset to default**
3. Confirm the action

### For Administrators

#### Enable/Disable Avatar Upload
1. Go to **General** settings
2. Toggle **Show Avatar** option
3. Save settings

#### Avatar Display Settings
- Size: 20-500px (General settings)
- Position: Part of menu layout
- Fallback: Uses Gravatar if no custom avatar

---

## Troubleshooting

### Common Issues & Solutions

#### Endpoints Not Showing
- **Issue:** New endpoints don't appear in menu
- **Solution:**
  1. Clear browser cache
  2. Go to **Settings → Permalinks**
  3. Click **Save Changes** (refreshes rewrite rules)
  4. Clear any caching plugins

#### Styles Not Applying
- **Issue:** Color changes don't show
- **Solution:**
  1. Clear browser cache
  2. Clear WordPress cache plugins
  3. Check theme compatibility
  4. Try different menu style (sidebar/tab)

#### Avatar Upload Fails
- **Issue:** Cannot upload avatar image
- **Solution:**
  1. Check file size (<2MB)
  2. Verify file type (JPG, PNG, GIF, WebP)
  3. Check folder permissions (wp-content/uploads)
  4. Increase PHP upload limit if needed

#### Menu Items Missing for Some Users
- **Issue:** Certain users can't see menu items
- **Solution:**
  1. Check role restrictions on endpoints
  2. Verify user's role assignment
  3. Clear user session/cookies
  4. Test with different user account

#### 404 Error on Custom Endpoints
- **Issue:** Custom endpoint URLs show 404
- **Solution:**
  1. Go to **Settings → Permalinks**
  2. Save without changes
  3. Clear cache
  4. Check for slug conflicts

### Getting Support

If issues persist:

1. **Check Documentation:** Review this guide
2. **Plugin Support:** Visit plugin support forum
3. **Debug Information:**
   - WordPress version
   - WooCommerce version
   - PHP version
   - Active theme
   - Other active plugins

---

## Best Practices

### Performance
- Limit endpoints to necessary items
- Use groups to organize many endpoints
- Optimize images for avatars
- Minimize content in endpoint pages

### Security
- Regularly update the plugin
- Use strong passwords
- Configure role restrictions properly
- Test changes on staging first

### User Experience
- Use clear, descriptive labels
- Choose appropriate icons
- Maintain consistent styling
- Group related items together
- Test on mobile devices

---

## Shortcodes

Use these shortcodes in endpoint content:

```
[customer_name] - Display customer's name
[customer_email] - Display customer's email
[order_count] - Show total orders
[last_order] - Display last order date
[membership_status] - Show membership level
```

---

## FAQs

**Q: Can I use this with any theme?**
A: Yes, the plugin works with any WooCommerce-compatible theme.

**Q: Will I lose settings if I deactivate?**
A: No, settings are preserved. They're only removed on uninstall.

**Q: Can I translate the plugin?**
A: Yes, the plugin is translation-ready. Use .po/.mo files.

**Q: Is it compatible with page builders?**
A: Yes, you can use page builder shortcodes in endpoint content.

**Q: Can I export/import settings?**
A: Currently manual backup via database export is supported.

---

## Changelog

### Version 1.4.1
- Security enhancements
- WordPress.org compliance updates
- Fixed avatar upload vulnerability
- Added proper sanitization
- Improved error handling

### Version 1.4.0
- Initial public release
- Core functionality implementation

---

*Last updated: November 2024*