<?php
/**
 * Applies PHP 8.5 compatibility patch to Carbon's Timestamp trait.
 * Adds #[\ReturnTypeWillChange] to createFromTimestamp() to suppress
 * deprecation notice caused by PHP 8.5's new DateTime::createFromTimestamp().
 *
 * Runs automatically via composer post-install-cmd.
 */

$file = __DIR__ . '/../vendor/nesbot/carbon/src/Carbon/Traits/Timestamp.php';

if (!file_exists($file)) {
    echo "Carbon Timestamp.php not found, skipping patch.\n";
    exit(0);
}

$contents = file_get_contents($file);

// Already patched
if (str_contains($contents, '#[\ReturnTypeWillChange]') && str_contains($contents, 'public static function createFromTimestamp($timestamp, $tz = null)')) {
    echo "Carbon PHP 8.5 patch already applied.\n";
    exit(0);
}

$patched = str_replace(
    'public static function createFromTimestamp($timestamp, $tz = null)',
    "#[\\ReturnTypeWillChange]\n    public static function createFromTimestamp(\$timestamp, \$tz = null)",
    $contents,
    $count
);

if ($count === 0) {
    echo "Could not find createFromTimestamp method to patch.\n";
    exit(1);
}

file_put_contents($file, $patched);
echo "Carbon PHP 8.5 patch applied successfully.\n";
