-- Reference schema for Hamayesh Conference Core.
-- Do not execute this file as-is: replace {prefix} with the WordPress $table_prefix.
-- Recommended installation: activate conference-core.php; WordPress dbDelta() creates/upgrades these tables.
-- All timestamps are UTC. Paper submission/review are free; no payment tables are used.

CREATE TABLE {prefix}hm_papers (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  event_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  title_en VARCHAR(255) NOT NULL DEFAULT '',
  abstract LONGTEXT NOT NULL,
  keywords VARCHAR(500) NOT NULL DEFAULT '',
  track VARCHAR(190) NOT NULL DEFAULT '',
  presentation_type VARCHAR(40) NOT NULL DEFAULT 'oral',
  coauthors LONGTEXT NULL,
  file_path TEXT NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  file_sha256 CHAR(64) NOT NULL DEFAULT '',
  status VARCHAR(32) NOT NULL DEFAULT 'submitted',
  version INT(10) UNSIGNED NOT NULL DEFAULT 1,
  submitted_at DATETIME NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY event_id (event_id),
  KEY status (status)
);

CREATE TABLE {prefix}hm_reviews (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  paper_id BIGINT(20) UNSIGNED NOT NULL,
  reviewer_id BIGINT(20) UNSIGNED NOT NULL,
  originality TINYINT UNSIGNED NOT NULL DEFAULT 0,
  methodology TINYINT UNSIGNED NOT NULL DEFAULT 0,
  clarity TINYINT UNSIGNED NOT NULL DEFAULT 0,
  relevance TINYINT UNSIGNED NOT NULL DEFAULT 0,
  recommendation VARCHAR(32) NOT NULL DEFAULT 'pending',
  comments LONGTEXT NOT NULL,
  confidential_comments LONGTEXT NULL,
  submitted_at DATETIME NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY paper_reviewer (paper_id, reviewer_id),
  KEY reviewer_id (reviewer_id),
  KEY recommendation (recommendation)
);

CREATE TABLE {prefix}hm_registrations (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  event_id BIGINT(20) UNSIGNED NOT NULL,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  attendance_type VARCHAR(20) NOT NULL DEFAULT 'in_person',
  status VARCHAR(24) NOT NULL DEFAULT 'registered',
  registration_code VARCHAR(48) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY event_user (event_id, user_id),
  UNIQUE KEY registration_code (registration_code),
  KEY user_id (user_id)
);

CREATE TABLE {prefix}hm_notifications (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  title VARCHAR(190) NOT NULL,
  message TEXT NOT NULL,
  read_at DATETIME NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY user_read (user_id, read_at)
);

CREATE TABLE {prefix}hm_certificates (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  paper_id BIGINT(20) UNSIGNED NOT NULL,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  certificate_code VARCHAR(64) NOT NULL,
  issued_at DATETIME NOT NULL,
  revoked_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY certificate_code (certificate_code),
  UNIQUE KEY paper_id (paper_id)
);

CREATE TABLE {prefix}hm_audit (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  actor_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  action VARCHAR(100) NOT NULL,
  object_type VARCHAR(40) NOT NULL DEFAULT '',
  object_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  details LONGTEXT NULL,
  ip_hash CHAR(64) NOT NULL DEFAULT '',
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY actor_id (actor_id),
  KEY object_ref (object_type, object_id),
  KEY action (action)
);
