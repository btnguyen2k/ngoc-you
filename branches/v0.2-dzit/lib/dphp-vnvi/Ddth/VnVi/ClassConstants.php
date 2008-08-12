<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Defines global constants used by Dddth::Vnvi package.
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU Lesser General
 * Public License that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/lgpl.html. If you did not receive a copy of
 * the GNU Lesser General Public License and are unable to obtain it through the web,
 * please send a note to gnu@gnu.org, or send an email to any of the file's authors
 * so we can email you a copy.
 *
 * @package		Vnvi
 * @author		NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @id			$Id: ClassConstants.php 111 2008-02-16 00:28:53Z btnguyen2k@gmail.com $
 * @since      	File available since v0.1
 */

/**
 * Defines global constants used by Dddth::Vnvi package.
 *
 * @package    	Vnvi
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @since      	Class available since v0.1
 */
class Ddth_Vnvi_Constants {
    //sorting order NONE, GRAVE, FALLING, TILDE, ACUTE, DROP
    //trat tu sap xep không dấu, huyền, hỏi, ngã, sắc, nặng

    /**
     * Khong dau
     */
    const MARK_NONE    = 0; //khong dau

    /**
     * Dau huyen
     */
    const MARK_GRAVE   = 1; //huyen

    /**
     * Dau hoi
     */
    const MARK_FALLING = 2; //hoi

    /**
     * Dau nga
     */
    const MARK_TILDE   = 3; //nga

    /**
     * Dau sac
     */
    const MARK_ACUTE   = 4; //sac

    /**
     * Dau nang
     */
    const MARK_DROP    = 5; //nang
}
?>