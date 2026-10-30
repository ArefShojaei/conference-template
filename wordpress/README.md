# WordPress package

Install `wordpress/themes/conference-1405` in `wp-content/themes/` and `wordpress/plugins/conference-core` in `wp-content/plugins/`. Activate both, save Permalinks, configure the Kavenegar VerifyLookup template in the plugin settings, then import demo content from Conference Core → Tools.

Shortcodes: `[conference_login]`, `[conference_register]`, `[conference_dashboard]`, `[conference_submit_paper]`, `[conference_papers]`.

Theme customizer controls the event details, three hero slide images/backgrounds, text, links and primary color. WordPress pages/posts and conference speakers/sessions are dynamic.

Paper upload accepts PDF, DOC and DOCX up to 20 MB and uses an authenticated download endpoint. On Nginx, deny direct access to `wp-content/uploads/conference-private`; `.htaccess` only protects Apache. Use HTTPS and set PHP upload_max_filesize/post_max_size to at least 20M (24M recommended). Real SMS delivery requires your Kavenegar API key and an approved VerifyLookup template. No payment or email-based registration is included.
