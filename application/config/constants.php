<?php

$server_name = $_SERVER['SERVER_NAME'];

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// ---------------------------------------------------------------------------------------------
defined('TRAVEL_MAX_PRICE_PER_KM') OR define('TRAVEL_MAX_PRICE_PER_KM', 0.10); // Highest price for the travel - set values for max price on offer-ride-part-2
defined('TRAVEL_MIN_PRICE_PER_KM') OR define('TRAVEL_MIN_PRICE_PER_KM', 0.04); // Highest price for the travel - set values for max price on offer-ride-part-2
// ---------------------------------------------------------------------------------------------


defined('Asset_path') OR define('Asset_path', 'http://localhost/dental/');

// AIzaSyBREMF2gH26r6gNypcVlo_-PSU_qIh2Yu8
// AIzaSyD64sZIBsE6am2XBXc3LjV1v8-ap6WKFEs
// AIzaSyCa2Z6_KWmvPTRlf11a7nFOGr8dWR07lQQ

defined('API_KEY') OR define('API_KEY', 'AIzaSyCa2Z6_KWmvPTRlf11a7nFOGr8dWR07lQQ'); // v! Default API Key use fot whole site
defined('DEFAULT_IMAGE_PATH') OR define('DEFAULT_IMAGE_PATH', Asset_path . 'public/front/images/'); // highest automatically-assigned error code
defined('DEFAULT_JS_PATH') OR define('DEFAULT_JS_PATH', Asset_path . 'public/front/js/'); // highest automatically-assigned error code
defined('DEFAULT_CSS_PATH') OR define('DEFAULT_CSS_PATH', Asset_path . 'public/front/css/'); // highest automatically-assigned error code
defined('DEFAULT_FONT_PATH') OR define('DEFAULT_FONT_PATH', Asset_path . 'public/front/fonts/'); // highest automatically-assigned error code
defined('DEFAULT_PLUGINS_PATH') OR define('DEFAULT_PLUGINS_PATH', Asset_path . 'public/front/plugins/'); // highest automatically-assigned error code

defined('DEFAULT_ADMIN_IMAGE_PATH') OR define('DEFAULT_ADMIN_IMAGE_PATH', Asset_path . 'public/back/img/'); // highest automatically-assigned error code
defined('DEFAULT_ADMIN_JS_PATH') OR define('DEFAULT_ADMIN_JS_PATH', Asset_path . 'public/back/js/'); // highest automatically-assigned error code
defined('DEFAULT_ADMIN_CSS_PATH') OR define('DEFAULT_ADMIN_CSS_PATH', Asset_path . 'public/back/css/'); // highest automatically-assigned error code
defined('DEFAULT_ADMIN_CKEDITOR_PATH') OR define('DEFAULT_ADMIN_CKEDITOR_PATH', Asset_path . 'public/back/ckeditor/'); // highest automatically-assigned error code

defined('DEFAULT_MOBILE_IMAGE_PATH') OR define('DEFAULT_MOBILE_IMAGE_PATH', Asset_path . 'public/mobile/img/'); // highest automatically-assigned error code
defined('DEFAULT_MOBILE_JS_PATH') OR define('DEFAULT_MOBILE_JS_PATH', Asset_path . 'public/mobile/js/'); // highest automatically-assigned error code
defined('DEFAULT_MOBILE_CSS_PATH') OR define('DEFAULT_MOBILE_CSS_PATH', Asset_path . 'public/mobile/css/'); // highest automatically-assigned error code