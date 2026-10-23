-- Reference only: do not run this file directly.
-- Activate conference-core.php instead; dbDelta() applies the schema using the site's actual table prefix.
-- All timestamps are UTC. Paper submission and peer review are free; no payment tables exist.
CREATE TABLE {prefix}hm_papers (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  event_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
  user_id BIGINT UNSIGNED NOT NULL,
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
  version INT UNSIGNED NOT NULL DEFAULT 1,
  submitted_at DATETIME NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY event_id (event_id),
  KEY status (status)
);
-- Remaining tables are defined in conference-core.php using dbDelta() to preserve WordPress compatibility.
