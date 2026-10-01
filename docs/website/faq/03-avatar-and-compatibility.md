# Avatar and Compatibility

## Can customers upload their own photo?

Yes, when **Member avatar upload** is on in the [General tab](../settings/02-general-tab.md). It is on by default.

## How does a customer upload a photo?

1. Open the My Account page.
2. Click the change-photo button on the avatar in the menu header.
3. In the **Upload your avatar** popup, choose an image and click **Upload**.

The customer returns to the My Account page and sees "Avatar updated successfully!".

## Which files are accepted?

JPG, PNG, GIF and WebP images, up to 2 MB. Other files show an error message. Your server's own upload limits still apply.

## Where is the photo stored?

In your Media Library. The plugin also remembers which user owns which image.

## Where does the photo show?

Wherever WordPress shows that user's avatar, for example comments and author boxes. The photo replaces the Gravatar while **Member avatar upload** is on.

## How does a customer remove the photo?

Open the same popup and click **Reset to default**. The image file is deleted from your Media Library and the normal avatar returns. The customer sees "Avatar removed successfully!".

## Can I turn the feature off?

Yes. Turn off **Member avatar upload** and save. Customers see their normal avatars again. The uploaded files stay in the Media Library.

## Will it conflict with other avatar plugins?

The plugin filters WordPress avatars at priority 100 and leaves other plugins' avatar filters in place. To hand avatar output to another source, use the `wcmp_get_avatar_filter` filter. See the [Developer Guide](../developer-guide/01-filters.md).

## Is there an RTL version?

Yes. The front-end stylesheet has a right-to-left version, which WordPress loads for RTL languages.
