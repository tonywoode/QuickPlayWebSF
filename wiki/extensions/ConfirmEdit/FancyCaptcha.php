<?php
/**
 * Experimental image-based captcha plugin, using images generated by an
 * external tool.
 *
 * Copyright (C) 2005, 2006 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/ConfirmEdit.php';
$wgCaptchaClass = 'FancyCaptcha';

global $wgCaptchaDirectory;
$wgCaptchaDirectory = "$wgUploadDirectory/captcha"; // bad default :D

global $wgCaptchaDirectoryLevels;
$wgCaptchaDirectoryLevels = 0; // To break into subdirectories

global $wgCaptchaSecret;
$wgCaptchaSecret = "CHANGE_THIS_SECRET!";

/**
 * By default the FancyCaptcha rotates among all available captchas.
 * Setting $wgCaptchaDeleteOnSolve to true will delete the captcha
 * files when they are correctly solved. Thus the user will need
 * something like a cron creating new thumbnails to avoid drying up.
 */
$wgCaptchaDeleteOnSolve = false;

$wgExtensionMessagesFiles['FancyCaptcha'] = dirname( __FILE__ ) . '/FancyCaptcha.i18n.php';
$wgAutoloadClasses['FancyCaptcha'] = dirname( __FILE__ ) . '/FancyCaptcha.class.php';
