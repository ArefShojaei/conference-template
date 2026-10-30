=== Conference Core ===
Contributors: conference-team
Requires at least: 6.2
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later

Core conference workflows for the Conference 1405 WordPress theme.

== Features ==
* Phone-number-only registration and login using one-time codes.
* Kavenegar VerifyLookup integration with API key kept server-side.
* Conference author, reviewer and manager roles.
* Private paper uploads: PDF, DOC, DOCX; maximum 20 MB; signature validation.
* Owner/reviewer/admin-only paper downloads.
* Paper submission receipts and reviewer/admin decisions can notify authors through configured SMS templates.
* Reviewer decision endpoint with optional SMS result notification.
* Dynamic speaker, schedule, team and news shortcodes; contact form messages are stored in the admin inbox with phone validation and IP rate limiting.
* No-payment attendee registration (no registration-type selector), managed from the WordPress admin and notified by SMS.
* User profile, papers, review history, status notifications and certificate listing shortcodes.
* Admin tools to seed demo speakers, sessions, committee members, posts and pages.

== Setup ==
1. Activate the plugin.
2. Configure Kavenegar API key and approved OTP, submission-receipt, paper-result, attendee-registration and attendee-status templates under Conference → SMS settings.
3. Create pages or use the pages generated on activation. Shortcodes: [conference_login], [conference_register], [conference_dashboard], [conference_submit_paper], [conference_papers], [conference_speakers], [conference_schedule], [conference_team], [conference_news], [conference_contact], [conference_event_registration], [conference_my_papers], [conference_review_queue], [conference_my_reviews], [conference_messages], [conference_profile], [conference_certificates].
4. Assign roles from Users. New signups are authors; users cannot select their role.
5. Run demo content import from Conference → Tools.

== Security ==
Use HTTPS. API keys must never be committed to the repository or exposed in browser code. For production, define CONFERENCE_KAVENEGAR_API_KEY in wp-config.php. Paper files are stored outside the public uploads URL and served through an authenticated handler. Apache receives a deny-all .htaccess; Nginx administrators must add an equivalent deny rule. DOCX validation requires PHP ZipArchive. Configure PHP upload_max_filesize and post_max_size to at least 20M (24M recommended). Use backups and server-side malware scanning.

== SMS ==
VerifyLookup templates must be approved by Kavenegar. Configure an OTP template with the code token and a result template with token (decision) and token2 (paper ID). Real SMS delivery cannot be verified until a valid account/API key and templates are configured on the target host.
