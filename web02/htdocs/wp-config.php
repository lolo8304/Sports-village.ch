<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache



/** JAMOS - Automatische Updates deaktivieren */
define( 'WP_AUTO_UPDATE_CORE', false );

/** JAMOS - Speicherlimit erhöhen */
define('WP_MEMORY_LIMIT', '64M');
/**
 * In dieser Datei werden die Grundeinstellungen für WordPress vorgenommen.
 *
 * Zu diesen Einstellungen gehören: MySQL-Zugangsdaten, Tabellenpräfix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es auf der {@link http://codex.wordpress.org/Editing_wp-config.php
 * wp-config.php editieren} Seite im Codex. Die Informationen für die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeugungsroutine verwendet. Sie wird ausgeführt, wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

/**  MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster. */
/**  Ersetze database_name_here mit dem Namen der Datenbank, die du verwenden möchtest. */
define('DB_NAME', 'db957886');

/** Ersetze username_here mit deinem MySQL-Datenbank-Benutzernamen */
define('DB_USER', 'db957886_adm');

/** Ersetze password_here mit deinem MySQL-Passwort */
define('DB_PASSWORD', 'Dg@m3u#a');

/** Ersetze localhost mit der MySQL-Serveradresse */
define('DB_HOST', 'nhl-mysqlw01');

/** Der Datenbankzeichensatz der beim Erstellen der Datenbanktabellen verwendet werden soll */
define('DB_CHARSET', 'utf8');

/** Der collate type sollte nicht geändert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden KEY in eine beliebige, möglichst einzigartige Phrase. 
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service} kannst du dir alle KEYS generieren lassen.
 * Bitte trage für jeden KEY eine eigene Phrase ein. Du kannst die Schlüssel jederzeit wieder ändern, alle angemeldeten Benutzer müssen sich danach erneut anmelden.
 *
 * @seit 2.6.0
 */
define('AUTH_KEY',         'Ddj:szvhCW7n|E0y dh%  )zP+DU_y&?-T#[bg@%GCu6he8tNvI_=H_o=mjg,L1p');
define('SECURE_AUTH_KEY',  'Ib W%Dc>y6Q(HS/+[>E|G)!dtm+y{X4]KAma*7AB*0%CB+?}~<5DYk/x+K<-^tQ0');
define('LOGGED_IN_KEY',    'U,A7_+=ChiCSrq%%{VoEZ]8e:##S6/(XfLQ,?*LXjv=1644z]Gx,P4kYc5cBOjYo');
define('NONCE_KEY',        '+L|]IO>YPAW:3-|x*x-oD*9{pw7#DT#vZh`T|&HpL43{X`0(0q~e |QFly8^]D0P');
define('AUTH_SALT',        'R*+!++?J|F&]]wgPVzl^|,HkY=c|gpg{?GNSj{~D{,dZOU k(~ikbp?m4eP7K>F;');
define('SECURE_AUTH_SALT', 'A7wn~+Q{>|qI)+64l4mEF;CNO,P-o+qtO1pZbU@##u*c0}&C.Z.SzvWn?HuCFs_S');
define('LOGGED_IN_SALT',   'h-Q8D]}j`+K3>SAJ|(DBp.T%}$@|,tr)V@Up6Fm{US{^X| +>z-?0Lblpk:&=/*<');
define('NONCE_SALT',       '9*.wAHYo-2ek!^Q^^Wt$;D?A*|.m5W]61-~Z&e%(*lR@Y&&|)fE. Ix<ly7)<#17');

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 *  Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Sprachdatei
 *
 * Hier kannst du einstellen, welche Sprachdatei benutzt werden soll. Die entsprechende
 * Sprachdatei muss im Ordner wp-content/languages vorhanden sein, beispielsweise de_DE.mo
 * Wenn du nichts einträgst, wird Englisch genommen.
 */
define('WPLANG', 'de_DE');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_TEMP_DIR', ABSPATH . "wp-content/temp");
