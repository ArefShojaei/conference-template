# Pre-production verification checklist

Do not launch with real researcher data until each applicable item is verified on a staging copy.

## Functional integration
- [ ] Convert the existing 26 HTML pages into WordPress templates/blocks without changing their visual design.
- [ ] Add integration tests for registration, email verification, login, logout, password reset, and duplicate accounts.
- [ ] Implement and test event registration persistence; the registrations table is present but the current MVP does not yet expose a complete registration workflow.
- [ ] Test paper submission, reviewer assignment, review submission, revision cycles, acceptance/rejection, and notifications.
- [ ] Add a complete author/reviewer/secretariat admin workflow and audit every status transition.
- [ ] Test certificate issuance, revocation, and public validation.
- [ ] Complete CSV export, pagination, filters, and accessibility keyboard navigation.

## Security
- [ ] Test all forms for CSRF, IDOR, privilege escalation, XSS, SQL injection and abuse/rate limits.
- [ ] Verify reviewers can access only papers assigned to them, including file download and confidential notes.
- [ ] Configure the private file directory outside the public document root where possible; otherwise add correct Apache and Nginx deny rules and verify direct URLs return 403/404.
- [ ] Add throttling for registration, login, verification resend, and password reset; monitor authentication abuse.
- [ ] Review user enumeration behavior and generic responses.
- [ ] Run current WordPress/PHP compatibility checks, PHPCS WordPress rules, dependency/security scans and an independent security review.

## Email, OAuth, SMS
- [ ] Configure authenticated SMTP and test delivery, SPF, DKIM and DMARC for the production domain.
- [ ] Google OAuth/OIDC is not included as an active provider in this MVP. Add it through a maintained plugin/provider, register production redirect URLs and test account-linking.
- [ ] SMS OTP is not included as an active provider in this MVP. If required, implement provider adapter, short OTP expiry, attempt and resend limits, phone verification state, and abuse monitoring.
- [ ] Never commit OAuth client secrets, SMTP passwords, SMS API keys or production configuration to Git.

## Operations
- [ ] Test on the exact production PHP/MySQL/WordPress versions and hosting stack.
- [ ] Enforce HTTPS, secure cookies, least-privilege administrator accounts, WAF/rate limiting and security updates.
- [ ] Configure daily database/file backups and complete a restore drill.
- [ ] Set privacy, consent, data retention/deletion and incident-response policies.
- [ ] Test mobile/desktop browsers, WCAG basics, error logs, mail failures and concurrent uploads.
- [ ] Replace all sample event dates, speakers, images, addresses and counts with verified content.
- [ ] Run an end-to-end acceptance test using non-production accounts and files.

## Current implementation boundary
This branch adds a WordPress plugin foundation: custom database tables, roles, account registration with email verification, login, private PDF storage, paper status updates, reviewer assignment/review forms, internal notifications, certificate lookup, event/speaker post types, and shortcodes. It is not a claim that the existing static website has already been converted to a complete WordPress theme or that every production check above has passed. Google OAuth, SMS OTP, a complete event registration workflow, and full end-to-end testing remain future work.
