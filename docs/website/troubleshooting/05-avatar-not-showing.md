# Avatar Is Not Showing

**Symptom:** a customer uploads a photo but still sees the old avatar, or there is no change-photo button.

## No change-photo button

1. Go to **WB Plugins > Woo My Account > General**.
2. Turn on **Member avatar upload**.
3. Click **Save Changes**.

The button appears on the avatar in the account menu header.

## Upload shows an error

- "Invalid file type. Only JPG, PNG, GIF and WebP images are allowed." Use one of those formats.
- "Image size must be less than 2MB." Use a smaller file.
- A message from WordPress about the upload. The upload failed in the Media Library. Check your server's upload size limit and the uploads folder permissions.

## Upload works but the photo does not show

1. Check that **Member avatar upload** is on. When it is off, the plugin does not replace avatars.
2. Reload the page. Clear the page cache if you use one.
3. Check that the server can resize images. The plugin makes a square copy of the photo at the size each place needs. If WordPress cannot create it (for example, no GD or Imagick library), the normal avatar shows.
4. Check for other avatar plugins. The plugin runs late (priority 100) and leaves other filters in place, but a custom code snippet on the `wcmp_get_avatar_filter` filter can turn it off.

## Reset does nothing

The reset form carries a one-time security token. Reload the My Account page while logged in and try **Reset to default** again. Reset only works for a customer who has uploaded a photo.

## Related

- [Avatar and compatibility](../faq/03-avatar-and-compatibility.md)
