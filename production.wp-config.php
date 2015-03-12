<?php
# Database Configuration
define( 'DB_NAME', 'wp_tilray' );
define( 'DB_USER', 'tilray' );
define( 'DB_PASSWORD', '0XYo7r22thMcVbX0dplc' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '&_oC 3Z`Y1`,` lZJT+tJ7wC@H?(is{+*I$(m0*kGV]eeY=-QI!/A5 297a=FM,?');
define('SECURE_AUTH_KEY',  'n?7>}T+]~F+mj5vVC*}ucDzg+;$6tBPO8]5xumuA;$>i?lA?EPQN_1 ^unthNiT&');
define('LOGGED_IN_KEY',    '1CDC|js<>oy8|y2m?Ms$~dVNN4QBbaTsOniYL|C CQ;^910yNT}wReeR(cT/c3P+');
define('NONCE_KEY',        '1rE7,&^H%=v3.$&J-L|dh10zks@yB6wWu}lLjL5Qs7bwG~+ 6<M^A6ag>|0_T//n');
define('AUTH_SALT',        '-{a5{l[*&h|l&WGXM@|csG-@G=%kB{i8MCfK(GC=RhY?JX wlgNon9J:Q8U1U+QV');
define('SECURE_AUTH_SALT', '@ps)%UP u{CaOIi<C$o8606MAd3WQtF;p+zpJ.(9+&F$[yP(|+z_:Bq@0F!W0=2K');
define('LOGGED_IN_SALT',   'lU}L@<PZr sp4f[-}2>2z-awli#eg.?!(ez$Y:EEx3Qu-}DiV|?}>9[(KmDn|`]L');
define('NONCE_SALT',       'Al-uWh)b@=.):jmQ{w1&Ls sLwXd#Kw,*LJ;e)W&x*4^Dz1mp{D!]3C#)+%;P<9K');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'tilray' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '9b035e38eb1f3af894ee9c16887f6c512919277c' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '1662' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 22 );

define( 'WPE_LBMASTER_IP', '66.175.209.245' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'tilray.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-1662', );

$wpe_special_ips=array ( 0 => '66.175.209.245', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
