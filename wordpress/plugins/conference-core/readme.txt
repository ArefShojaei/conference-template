=== Conference Core ===
Contributors: conference-team
Requires at least: 6.2
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later

The application layer for Conference 1405: mobile OTP authentication, roles and capabilities, secure paper workflows, reviewer assignments, attendee registrations, notifications, contact inbox, certificates and conference content types. Keep business logic here so it survives theme changes.

== Features ==
* Phone-number-only registration and login using one-time codes.
* Kavenegar VerifyLookup integration with API key kept server-side.
* Conference author, reviewer and manager roles.
* Private paper uploads: PDF, DOC, DOCX; maximum 20 MB; signature validation.
* Owner/reviewer/admin-only paper downloads.
* Paper submission receipts and reviewer/admin decisions can notify authors through configured SMS templates.
* Reviewer decision endpoint with optional SMS result notification.
* Editable session metadata (conference day, start/end time, room and speaker) rendered as a grouped chronological schedule; dynamic speaker, team and news shortcodes; contact form messages are stored in the admin inbox with phone validation and IP rate limiting.
* No-payment attendee registration (no registration-type selector), managed from the WordPress admin and notified by SMS.
* User profile, papers, review history, status notifications and certificate listing shortcodes.
* Admin tools to seed demo speakers, sessions, committee members, posts and pages.

== Setup ==
1. Activate the plugin.
2. Configure Kavenegar API key and approved OTP, submission-receipt, paper-result, attendee-registration and attendee-status templates under Conference → SMS settings.
3. All public, user, reviewer and administrator pages are provisioned automatically, including `/login/`, `/register/`, `/dashboard/`, `/reviewer-dashboard/`, `/review-paper/` and `/admin-dashboard/` plus management routes. Shortcodes include [conference_login], [conference_register], [conference_dashboard], [conference_submit_paper], [conference_papers], [conference_speakers], [conference_schedule], [conference_team], [conference_news], [conference_contact], [conference_event_registration], [conference_my_papers], [conference_review_queue], [conference_my_reviews], [conference_messages], [conference_profile], [conference_certificates], [conference_reviewer_dashboard], [conference_review_paper] and [conference_admin_workspace].
4. Assign roles from Users. New signups are authors; users cannot select their role.
5. Run demo content import from Conference → Tools.

== Security ==
Use HTTPS. API keys must never be committed to the repository or exposed in browser code. For production, define CONFERENCE_KAVENEGAR_API_KEY in wp-config.php. New paper files are stored outside the web document root by default and served only through an authenticated handler. You may set CONFERENCE_PRIVATE_STORAGE_DIR to an absolute writable path that remains outside the document root. Legacy files from the older uploads-based location remain supported for download; block that legacy URL at Nginx/Apache if any such files remain. DOCX validation requires PHP ZipArchive. Configure PHP upload_max_filesize and post_max_size to at least 20M (24M recommended). Use backups and server-side malware scanning.

== SMS ==
VerifyLookup templates must be approved by Kavenegar. Configure an OTP template with the code token and a result template with token (decision) and token2 (paper ID). Real SMS delivery cannot be verified until a valid account/API key and templates are configured on the target host.

== Theme and plugin responsibilities ==
The Conference 1405 theme owns presentation: RTL layout, responsive styling, navigation, homepage slider, Customizer settings and template rendering. Conference Core owns application behavior and data workflows: OTP authentication, capabilities, submissions, review, registrations, SMS, contact messages, certificates and conference post types. Keeping these responsibilities separate means a future theme change does not remove submitted papers or authentication workflows.

== Portable SQL demo content ==
See `wordpress/demo-content/conference-demo.sql` and `wordpress/demo-content/SQL-IMPORT.md`. Replace the `wp_` table prefix with the destination site's actual WordPress table prefix before importing. Activate the plugin first so the conference post types are registered.
