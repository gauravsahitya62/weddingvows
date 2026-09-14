<?php
/**
 * Loads the dated SEO Journal seed through WordPress' native MU-plugin layer.
 * The seed is one-shot and guarded by a dedicated option, so it cannot
 * overwrite existing posts or rerun after successful publication.
 */
require_once get_theme_file_path('inc/seo-journal-2026-09-14.php');
