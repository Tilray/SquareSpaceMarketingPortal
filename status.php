<?
function countOccurrences($url, $connection)
{
	$result1 = mysql_num_rows(mysql_query('SELECT * FROM `wp_icl_string_positions` WHERE position_in_page LIKE \'%'. $url .'%\'', $connection));
	$result2 = mysql_num_rows(mysql_query('SELECT * FROM `wp_icl_translation_status` WHERE translation_package LIKE \'%'. $url .'%\'', $connection));
	$result3 = mysql_num_rows(mysql_query('SELECT * FROM `wp_options` WHERE option_value LIKE \'%'. $url .'%\'', $connection));
	$result4 = mysql_num_rows(mysql_query('SELECT * FROM `wp_postmeta` WHERE meta_value LIKE \'%'. $url .'%\'', $connection));
	$result5 = mysql_num_rows(mysql_query('SELECT * FROM `wp_posts` WHERE guid LIKE \'%'. $url .'%\' OR post_content LIKE \'%'. $url .'%\' OR post_excerpt LIKE \'%'. $url .'%\'', $connection));
	
	echo "Found <b>" . $result1 . ", " . $result2 . ", " . $result3 . ", " . $result4 . ", " . $result5 . "</b> occurrences of " . $url . " <i>(should be 0)</i><br/>";
	
	mysql_free_result($result1);
	mysql_free_result($result2);
	mysql_free_result($result3);
	mysql_free_result($result4);
	mysql_free_result($result5);
}

include 'wp-config.php';

echo "homeurl defined in wp-config.php: <b>" . WP_HOME . '</b> <i>(should be WP_HOME)</i><br/>';
echo "siteurl defined in wp-config.php: <b>" . WP_SITEURL . '</b> <i>(should be WP_SITEURL)</i><br/>';
echo "DB_name defined in wp-config.php: <b>" . DB_NAME . '</b> <i>(should be wp_tilray)</i><br/>';

// Create connection
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!mysql_select_db(DB_NAME, $conn)) {
    echo 'Could not select database';
    exit;
}

countOccurrences("tilray.wpengine.com", $conn);
countOccurrences("tilray.staging.wpengine.com", $conn);
countOccurrences("https://tilray.ca", $conn);
countOccurrences("http://tilray.ca", $conn);
countOccurrences("http://www.tilray.ca", $conn);

?>