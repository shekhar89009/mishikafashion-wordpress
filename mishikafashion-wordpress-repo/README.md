# MishikaFashion WordPress

A WordPress affiliate catalog split into two independently installable packages:

- `plugin/dealnest-affiliate-manager` — Affiliate Product Manager v1.2.1
- `theme/dealnest-theme` — DealNest theme v1.2.2

## GitHub release assets

Every release should upload the installable ZIPs at the release root:

- `dealnest-affiliate-manager.zip`
- `dealnest-theme.zip`

The theme and plugin each have their own GitHub updater. A theme-only release can therefore update only the theme; the plugin does not need to be re-uploaded or reinstalled.

## GitHub settings in WordPress

In **Affiliate Products → GitHub Updates**, set:

- GitHub username / organization: your GitHub owner
- Repository: `mishikafashion-wordpress`
- GitHub token: only required if the repository is private

For the theme updater, the same repository settings are available under **Appearance → Theme Settings → GitHub Updates**.

## Important

Uploading files to the repository alone does not create a WordPress update. Publish a new GitHub Release with a higher semantic version and the correct ZIP asset. The update checker reads published releases.
