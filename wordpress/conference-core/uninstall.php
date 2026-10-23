<?php
defined('WP_UNINSTALL_PLUGIN') || exit;
// Keep user-submitted research, reviews, audit logs and certificates by default.
// Explicit deletion must be an intentional, documented database operation after backup.
// Remove only plugin options; do not delete accounts or submitted papers.
delete_option('hm_core_db_version');
delete_option('hm_email_notifications');
delete_option('hm_auto_certificate');
