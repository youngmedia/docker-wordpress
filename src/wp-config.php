<?php
define( 'WP_CACHE', true);

/* MySQL settings */
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME'));
define( 'DB_USER', getenv('WORDPRESS_DB_USER'));
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD'));
define( 'DB_HOST', getenv('WORDPRESS_DB_HOST'));
define( 'DB_CHARSET',  'utf8' );

define( 'AUTH_KEY',         'cU?8`DF!y8=OB}&AF U(j3[`X~JzoHFZ05l!7hl7bffD3~+Vz,Z#uC|+4})V&c#E' );
define( 'SECURE_AUTH_KEY',  ';ycch5`il9[B/pnJcCI7Xg90WW<ucUUbviW[VM+GHM17$ah>BD?i4A>,~$zFzoD{' );
define( 'LOGGED_IN_KEY',    ',hPLNh P-#!e4Aj K8gV.h44qA>0InV|#~n&gp[uQmf4TrQblz:vJO{X-PVSy*fO' );
define( 'NONCE_KEY',        'C+&~Z.zXpv$TtP 5A~.?%ef~B>(Yn~;yN{GIZ2p!)rrrJ9Rx4V%ll<yji$g#@G{}' );
define( 'AUTH_SALT',        'hNzmQcwU]ZB]g?;c#}prHLh#`}wqLx|kdx;}U?=nF]_&*o!d(Ia}HyqQ)#EXq.Zv' );
define( 'SECURE_AUTH_SALT', '=wbe;96OU}W<G`<}*(LqAvS>Jo9n(X{@$Iltchs+BSz#.20PW]PZeU6a4-#l-NB)' );
define( 'LOGGED_IN_SALT',   ' eFEUs/g;[:ee7sbAs;)A7@KR(}3-k.mEml!)E?!RrU 8;<hq 4jH^OXW9+m:5M7' );
define( 'NONCE_SALT',       'y/$Yw3:OvF .h )FlAq<bJG7L#k{?|=Fx(OoPOhZL`+N_28bn93JtI$aq**a!LZ6' );

$table_prefix  = getenv('WORDPRESS_DB_PREFIX') ? getenv('WORDPRESS_DB_PREFIX') : 'wp_';

// Turns WordPress debugging on
define('WP_DEBUG', getenv('WORDPRESS_DEBUG'));

// Doesn't force the PHP 'display_errors' variable to be on
// define('WP_DEBUG_DISPLAY', getenv('WORDPRESS_DEBUG'));

// define( 'WP_SITEURL', WP_HOME . '/wp');
// define( 'WP_CONTENT_URL', WP_HOME . '/wp-content');
// define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );

if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
  $_SERVER['HTTPS']='on';

/* Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/* Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');