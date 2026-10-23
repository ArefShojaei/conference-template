# Hamayesh Conference Core (WordPress)

This is a backend plugin foundation for the Persian/RTL conference UI in the repository. Install it as a plugin at `wp-content/plugins/conference-core/` and activate it. It creates the core custom tables with WordPress `dbDelta()`, conference/speaker post types, and shortcode pages.

## Included
- WordPress-native accounts, password hashing, nonces and capability checks
- Email verification with random single-use token hash and 24-hour expiry
- Researcher, reviewer and secretariat roles
- Free paper submission (no payment fields, checkout, fees or payment gateway)
- PDF-only server-side checks, 10 MB cap, private file storage and authorized download handler
- Paper status management, reviewer assignment and scored review form
- Internal notifications, configurable email notifications and audit trail
- Certificate code generation and public certificate verification
- Event and speaker content types
- Dashboard, registration, login, paper submission, reviewer and certificate shortcodes

## Install
1. Back up the site and install on staging first.
2. Copy this folder to `wp-content/plugins/conference-core/`.
3. Activate **Hamayesh Conference Core** in WordPress Admin → Plugins.
4. Configure HTTPS and SMTP (e.g. a reputable SMTP plugin/provider) and test delivery.
5. Create an administrator backup account, set strong unique passwords, and confirm WordPress cron/backup monitoring.
6. Assign the **Secretariat** role only to trusted staff. Create reviewer accounts in Users and assign **Reviewer**.
7. Create events under **همایش‌ها**. The default event is informational; this plugin deliberately does not charge for paper submission or event registration.
8. Use the generated pages: `/hm-register/`, `/hm-login/`, `/hm-verify-email/`, `/hm-submit-paper/`, `/hm-dashboard/`, `/hm-reviewer/`, and `/hm-certificate-verify/`.
9. Test email verification, rejected/accepted status, review assignment, file permissions and backups on staging before production.

## Shortcodes
- `[hm_register]`
- `[hm_login]`
- `[hm_verify_email]`
- `[hm_submit_paper]`
- `[hm_dashboard]`
- `[hm_reviewer_dashboard]`
- `[hm_certificate_verify]`
- `[hm_events]`

## Database
On activation, the plugin creates versioned custom tables using the active WordPress prefix:
- `{prefix}hm_papers`
- `{prefix}hm_reviews`
- `{prefix}hm_registrations`
- `{prefix}hm_notifications`
- `{prefix}hm_certificates`
- `{prefix}hm_audit_log`

Do not manually import WordPress core rows into `wp_posts` or `wp_users`. The plugin's migration is safer than a prefix-specific SQL dump. For review or migration planning, see `schema-reference.sql`; it is a schema reference only, not an import script.

## Google OAuth and SMS
Google sign-in and SMS OTP are intentionally **not advertised as working out of the box**. They require OAuth client credentials/redirect URI and a vetted identity plugin, or a server-side SMS provider, API credentials, OTP expiry, resend throttling, attempt limits and abuse monitoring. Use a maintained OAuth/OIDC plugin and connect its account-created/login hooks to the email-verification policy. Do not put provider secrets in source control. Never use a user-submitted phone number as proof of identity without OTP verification.

## Important production caveats
This is a production-oriented foundation, not a certification that the whole website is ready for public launch. It has not been tested against your host, mail provider, CDN/WAF, PHP/MySQL versions, or your current theme. The HTML pages in the repository remain a static prototype until converted to WordPress templates or wired to these shortcodes. Before public launch, complete browser/integration tests, independent security review, privacy/retention policy, restore test, accessibility check, load test and review of local legal obligations. Configure server-level deny rules for the private upload directory on Nginx as well as Apache; the plugin also checks authorization in its download handler. If storage is not outside the public web root, configure it explicitly before accepting real submissions.
