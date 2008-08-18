<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/* This file MUST be saved in UTF-8 character encoding! */
/**
 * Utf8 support for vi_VN.
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
 * @id			$Id: ClassUtf8.php 147 2008-03-09 06:00:32Z nbthanh@vninformatics.com $
 * @since      	File available since v0.1
 */

/** */
require_once 'ClassConstants.php';

/**
 * Utf8 support for vi_VN.
 *
 * This class provides support for vi_VN with Utf8 character encoding.
 *
 * @package    	Vnvi
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @since      	Class available since v0.1
 */
class Ddth_Vnvi_Utf8 {

    const ENCODING = 'UTF-8';

    private static $instance = NULL;

    private static $tblToneMarkMapping = Array (
    	'à' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ả' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ã' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'á' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ạ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ằ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ẳ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ẵ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ắ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ặ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ầ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ẩ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ẫ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ấ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ậ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'è' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ẻ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ẽ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'é' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ẹ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ề' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ể' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ễ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ế' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ệ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ì' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ỉ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ĩ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'í' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ị' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ò' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ỏ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'õ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ó' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ọ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ồ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ổ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ỗ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ố' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ộ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ờ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ở' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ỡ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ớ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ợ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ù' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ủ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ũ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ú' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ụ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ừ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ử' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ữ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ứ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ự' => Ddth_Vnvi_Constants::MARK_DROP,
    	'ỳ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'ỷ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'ỹ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'ý' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'ỵ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'À' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ả' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ã' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Á' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ạ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ầ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ẳ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ẵ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ắ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ặ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ầ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ẩ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ẫ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ấ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ậ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'È' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ẻ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ẽ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'É' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ẹ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ề' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ể' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ễ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ế' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ệ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ì' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ỉ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ĩ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Í' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ị' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ò' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ỏ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Õ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ó' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ọ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ồ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ổ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ỗ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ố' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ộ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ờ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ở' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ỡ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ớ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ợ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ù' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ủ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ũ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ú' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ụ' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ừ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ử' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ữ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ứ' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ự' => Ddth_Vnvi_Constants::MARK_DROP,
    	'Ỳ' => Ddth_Vnvi_Constants::MARK_GRAVE,
    	'Ỷ' => Ddth_Vnvi_Constants::MARK_FALLING,
    	'Ỹ' => Ddth_Vnvi_Constants::MARK_TILDE,
    	'Ý' => Ddth_Vnvi_Constants::MARK_ACUTE,
    	'Ỵ' => Ddth_Vnvi_Constants::MARK_DROP);

    private static $tblAllLettersLower = Array (
    	'a', 'à', 'ả', 'ã', 'á', 'ạ',
    	'ă', 'ằ', 'ẳ', 'ẵ', 'ắ', 'ặ',
    	'â', 'ầ', 'ẩ', 'ẫ', 'ấ', 'ậ',
    	'b', 'c', 'd', 'đ',
    	'e', 'è', 'ẻ', 'ẽ', 'é', 'ẹ',
    	'ê', 'ề', 'ể', 'ễ', 'ế', 'ệ',
        'f', 'g', 'h',
    	'i', 'ì', 'ỉ', 'ĩ', 'í', 'ị',
    	'j', 'k', 'l', 'm', 'n',
    	'o', 'ò', 'ỏ', 'õ', 'ó', 'ọ',
    	'ô', 'ồ', 'ổ', 'ỗ', 'ố', 'ộ',
    	'ơ', 'ờ', 'ở', 'ỡ', 'ớ', 'ợ',
    	'p', 'q', 'r', 's', 't',
     	'u', 'ù', 'ủ', 'ũ', 'ú', 'ụ',
    	'ư', 'ừ', 'ử', 'ữ', 'ứ', 'ự',
    	'v', 'w', 'x',
    	'y', 'ỳ', 'ỷ', 'ỹ', 'ý', 'ỵ',
    	'z');

    private static $tblAllLettersUpper = Array (
    	'A', 'À', 'Ả', 'Ã', 'Á', 'Ạ',
    	'Ă', 'Ầ', 'Ẳ', 'Ẵ', 'Ắ', 'Ặ',
    	'Â', 'Ầ', 'Ẩ', 'Ẫ', 'Ấ', 'Ậ',
    	'B', 'C', 'D', 'Đ',
    	'E', 'È', 'Ẻ', 'Ẽ', 'É', 'Ẹ',
    	'Ê', 'Ề', 'Ể', 'Ễ', 'Ế', 'Ệ',
        'F', 'G', 'H',
    	'I', 'Ì', 'Ỉ', 'Ĩ', 'Í', 'Ị',
    	'J', 'K', 'L', 'M', 'N',
    	'O', 'Ò', 'Ỏ', 'Õ', 'Ó', 'Ọ',
    	'Ô', 'Ồ', 'Ổ', 'Ỗ', 'Ố', 'Ộ',
    	'Ơ', 'Ờ', 'Ở', 'Ỡ', 'Ớ', 'Ợ',
    	'P', 'Q', 'R', 'S', 'T',
     	'U', 'Ù', 'Ủ', 'Ũ', 'Ú', 'Ụ',
    	'Ư', 'Ừ', 'Ử', 'Ữ', 'Ứ', 'Ự',
    	'V', 'W', 'Z',
    	'Y', 'Ỳ', 'Ỷ', 'Ỹ', 'Ý', 'Ỵ',
    	'Z');

    private static $toneMarkRemovalSearches = NULL;
    private static $toneMarkRemovalReplaces = NULL;
    private static $tblToneMarkRemoval = Array(
        'À' => 'A', 'à' => 'a',
        'Ả' => 'A', 'ả' => 'a',
        'Ã' => 'A', 'ã' => 'a',
		'Á' => 'A', 'á' => 'a',
        'Ạ' => 'A', 'ạ' => 'a',
        'Ằ' => 'Ă', 'ằ' => 'ă',
        'Ẳ' => 'Ă', 'ẳ' => 'ă',
        'Ẵ' => 'Ă', 'ẵ' => 'ă',
        'Ắ' => 'Ă', 'ắ' => 'ă',
        'Ặ' => 'Ă', 'ặ' => 'ă',
        'Ầ' => 'Â', 'ầ' => 'â',
        'Ẩ' => 'Â', 'ầ' => 'â',
        'Ẫ' => 'Â', 'ẫ' => 'â',
        'Ấ' => 'Â', 'ấ' => 'â',
        'Ậ' => 'Â', 'ậ' => 'â',
        'È' => 'E', 'è' => 'e',
        'Ẻ' => 'E', 'ẻ' => 'e',
        'Ẽ' => 'E', 'ẻ' => 'e',
        'É' => 'E', 'é' => 'e',
        'Ẹ' => 'E', 'é' => 'e',
        'Ề' => 'Ê', 'ề' => 'ê',
        'Ể' => 'Ê', 'ể' => 'ê',
        'Ễ' => 'Ê', 'ễ' => 'ê',
        'Ế' => 'Ê', 'ế' => 'ê',
        'Ệ' => 'Ê', 'ế' => 'ê',
        'Ì' => 'I', 'ì' => 'i',
        'Ỉ' => 'I', 'ỉ' => 'i',
        'Ĩ' => 'I', 'ĩ' => 'i',
        'Í' => 'I', 'í' => 'i',
        'Ị' => 'I', 'ị' => 'i',
        'Ò' => 'O', 'ò' => 'o',
        'Ỏ' => 'O', 'ỏ' => 'o',
        'Õ' => 'O', 'õ' => 'o',
        'Ó' => 'O', 'ó' => 'o',
        'Ọ' => 'O', 'ọ' => 'o',
        'Ồ' => 'Ô', 'ồ' => 'ô',
        'Ổ' => 'Ô', 'ồ' => 'ô',
        'Ỗ' => 'Ô', 'ỗ' => 'ô',
        'Ố' => 'Ô', 'ố' => 'ô',
        'Ộ' => 'Ô', 'ộ' => 'ô',
        'Ờ' => 'Ơ', 'ờ' => 'ơ',
        'Ở' => 'Ơ', 'ở' => 'ơ',
        'Ỡ' => 'Ơ', 'ỡ' => 'ơ',
        'Ớ' => 'Ơ', 'ớ' => 'ơ',
        'Ợ' => 'Ơ', 'ợ' => 'ơ',
        'Ù' => 'U', 'ù' => 'u',
        'Ủ' => 'U', 'ù' => 'u',
        'Ũ' => 'U', 'ũ' => 'u',
        'Ú' => 'U', 'ú' => 'u',
        'Ụ' => 'U', 'ú' => 'u',
        'Ừ' => 'Ư', 'ừ' => 'ư',
        'Ử' => 'Ư', 'ừ' => 'ư',
        'Ữ' => 'Ư', 'ữ' => 'ư',
        'Ứ' => 'Ư', 'ứ' => 'ư',
        'Ự' => 'Ư', 'ự' => 'ư',
        'Ỳ' => 'Y', 'ỳ' => 'y',
        'Ỷ' => 'Y', 'ỷ' => 'y',
        'Ỹ' => 'Y', 'ỹ' => 'y',
        'Ý' => 'Y', 'ý' => 'y',
        'Ỵ' => 'Y', 'ỵ' => 'y');

    private static $deVietnameseSearches = NULL;
    private static $deVietnameseReplaces = NULL;
    private static $tblDeVietnamese = Array(
    	'À' => 'A', 'à' => 'a',
    	'Ả' => 'A', 'ả' => 'a',
        'Ã' => 'A', 'ã' => 'a',
     	'Á' => 'A', 'á' => 'a',
     	'Ạ' => 'A', 'ạ' => 'a',
     	'Ă' => 'A', 'ă' => 'a',
     	'Ằ' => 'A', 'ằ' => 'a',
     	'Ẳ' => 'A', 'ẳ' => 'a',
     	'Ẵ' => 'A', 'ẵ' => 'a',
     	'Ắ' => 'A', 'ắ' => 'a',
     	'Ặ' => 'A', 'ặ' => 'a',
     	'Â' => 'A', 'â' => 'a',
     	'Ầ' => 'A', 'ầ' => 'a',
     	'Ẩ' => 'A', 'ẩ' => 'a',
     	'Ẫ' => 'A', 'ẫ' => 'a',
     	'Ấ' => 'A', 'ấ' => 'a',
     	'Ậ' => 'A', 'ậ' => 'a',
    	'Đ' => 'D', 'đ' => 'd',
    	'È' => 'E', 'è' => 'e',
     	'Ẻ' => 'E', 'ẻ' => 'e',
     	'Ẽ' => 'E', 'ẽ' => 'e',
     	'É' => 'E', 'é' => 'e',
     	'Ẹ' => 'E', 'ẹ' => 'e',
     	'Ê' => 'E', 'ê' => 'e',
     	'Ề' => 'E', 'ề' => 'e',
     	'Ể' => 'E', 'ể' => 'e',
     	'Ễ' => 'E', 'ễ' => 'e',
     	'Ế' => 'E', 'ế' => 'e',
     	'Ệ' => 'E', 'ệ' => 'e',
    	'Ì' => 'I', 'ì' => 'i',
     	'Ỉ' => 'I', 'ỉ' => 'i',
     	'Ĩ' => 'I', 'ĩ' => 'i',
     	'Í' => 'I', 'í' => 'i',
     	'Ị' => 'I', 'ị' => 'i',
     	'Ò' => 'O', 'ò' => 'o',
     	'Ỏ' => 'O', 'ỏ' => 'o',
     	'Õ' => 'O', 'õ' => 'o',
     	'Ó' => 'O', 'ó' => 'o',
     	'Ọ' => 'O', 'ọ' => 'o',
     	'Ô' => 'O', 'ô' => 'o',
     	'Ồ' => 'O', 'ồ' => 'o',
     	'Ổ' => 'O', 'ổ' => 'o',
     	'Ỗ' => 'O', 'ỗ' => 'o',
     	'Ố' => 'O', 'ố' => 'o',
     	'Ộ' => 'O', 'ộ' => 'o',
     	'Ơ' => 'O', 'ơ' => 'o',
     	'Ờ' => 'O', 'ờ' => 'o',
     	'Ở' => 'O', 'ở' => 'o',
     	'Ỡ' => 'O', 'ỡ' => 'o',
     	'Ớ' => 'O', 'ớ' => 'o',
     	'Ợ' => 'O', 'ợ' => 'o',
    	'Ù' => 'U', 'ù' => 'u',
     	'Ủ' => 'U', 'ủ' => 'u',
     	'Ũ' => 'U', 'ũ' => 'u',
     	'Ú' => 'U', 'ú' => 'u',
     	'Ụ' => 'U', 'ụ' => 'u',
     	'Ư' => 'U', 'ư' => 'u',
     	'Ừ' => 'U', 'ừ' => 'u',
     	'Ử' => 'U', 'ử' => 'u',
     	'Ữ' => 'U', 'ữ' => 'u',
     	'Ứ' => 'U', 'ứ' => 'u',
     	'Ự' => 'U', 'ự' => 'u',
     	'Ỳ' => 'Y', 'ỳ' => 'y',
     	'Ỷ' => 'Y', 'ỷ' => 'y',
     	'Ỹ' => 'Y', 'ỹ' => 'y',
     	'Ý' => 'Y', 'ý' => 'y',
     	'Ỵ' => 'Y', 'ỵ' => 'y');

    /**
     * Constructs a new Ddth_Vnvi_Utf8 object.
     */
    protected function __construct() {
        self::$toneMarkRemovalSearches = Array();
        self::$toneMarkRemovalReplaces = Array();
        foreach ( self::$tblToneMarkRemoval as $key => $value ) {
            self::$toneMarkRemovalSearches[] = $key;
            self::$toneMarkRemovalReplaces[] = $value;
        }

        self::$deVietnameseSearches = Array();
        self::$deVietnameseReplaces = Array();
        foreach ( self::$tblDeVietnamese as $key => $value ) {
            self::$deVietnameseSearches[] = $key;
            self::$deVietnameseReplaces[] = $value;
        }
    }

    /**
     * Gets instance of this class.
     *
     * @return Ddth_Vnvi_Utf8
     */
    public static function getInstance() {
        if ( self::$instance === NULL ) {
            self::$instance = new Ddth_Vnvi_Utf8();
        }
        return self::$instance;
    }

    /**
     * Compares 2 Vietnamese letters.
     *
     * @param char
     * @param char
     * @param bool specify if the comparison is case-insensitive or not
     * @return int negative if the first letter is less than the second one,
     * positive if the first letter is large than the second one, zero if both
     * letters are equal
     */
    protected function compareLetters($letter1, $letter2, $caseInsensitive=false) {
        $isLower1 = true;
        $pos1 = array_search($letter1, self::$tblAllLettersLower);
        if ( $pos1 === false ) {
            $isLower1 = false;
            $pos1 = array_search($letter1, self::$tblAllLettersUpper);
        }

        $isLower2 = true;
        $pos2 = array_search($letter2, self::$tblAllLettersLower);
        if ( $pos2 === false ) {
            $isLower2 = false;
            $pos2 = array_search($letter2, self::$tblAllLettersUpper);
        }

        if ( $pos1===false || $pos2===false ) {
            //not Vietnamese letter
            if ( $caseInsensitive ) {
                $letter1 = strtolower($letter1);
                $letter2 = strtolower($letter2);
            }
            return $letter1 < $letter2 ? -1 : ($letter1 > $letter2 ? 1 : 0);
        }

        if ( !$caseInsensitive ) {
            if ( $isLower1 ) {
                $pos1 += count(self::$tblAllLettersLower);
            }
            if ( $isLower2 ) {
                $pos2 += count(self::$tblAllLettersLower);
            }
        }
        return $pos1 < $pos2 ? -1 : ($pos1 > $pos2 ? 1 : 0);
    }

    //taken from http://vn.php.net/mb_split
    private function mbStringToArray($str) {
        $len = mb_strlen($str);
        $result = Array();
        while ( $len ) {
            $result[] = mb_substr($str, 0, 1, self::ENCODING);
            $str = mb_substr($str, 1, $len, self::ENCODING);
            $len = mb_strlen($str);
        }
        return $result;
    }

    /**
     * Compares 2 Vietnamese strings.
     *
     * @param string
     * @param string
     * @param bool specify if the comparison is case-insensitive or not
     * @return int negative if the first string is less than the second one,
     * positive if the first string is large than the second one, zero if both
     * strings are equal
     */
    public function compareStrings($str1, $str2, $caseInsensitive=false) {
        $letters1 = $this->mbStringToArray($str1);
        $letters2 = $this->mbStringToArray($str2);
        $n1 = count($letters1);
        $n2 = count($letters2);
        for ( $i = 0, $n = min(Array($n1, $n2)); $i < $n; $i++ ) {
            $result = $this->compareLetters($letters1[$i], $letters2[$i], $caseInsensitive);
            if ( $result !== 0 ) {
                return $result;
            }
        }
        //all equals, see who is longer
        return $n1 < $n2 ? -1 : ($n1 > $n2 ? 1 : 0);
    }
    
    /**
     * Compares 2 Vietnamese words.
     * 
     * This method will compare 2 Vietnamese words according to Vietnamese name
     * ordering rule. Which means:
     * <code>
     * - words are trimmed period to comparison
     * - hòa = hoà (same words, different position of tone marks)
     * </code>
     * 
     * @param string
     * @param string
     * @param bool specify if the comparison is case-insensitive or not
     * @return int negative if the first word is less than the second one,
     * positive if the first word is large than the second one, zero if both
     * words are equal
     */
    public function compareWords($word1, $word2, $caseInsensitive=false) {
        $word1 = trim($word1);
        $mark1 = $this->getWordToneMark($word1);
        $word1 = $this->removeToneMarks($word1);
        $word2 = trim($word2);
        $mark2 = $this->getWordToneMark($word2);
        $word2 = $this->removeToneMarks($word2);
        $result = $this->compareStrings($word1, $word2, $caseInsensitive);
        if ( $result !== 0 ) {
            //word ordering has higher priority than tone mark ordering
            return $result;
        }
        return $mark1 < $mark2 ? -1 : ($mark1 > $mark2 ? 1 : 0);
    }

    /**
     * De-Vietnameses a string.
     *
     * @param string
     * @return string the string after de-Vietnamesed
     */
    public function deVietnamese($str) {
        if ( !is_string($str) ) {
            return $str;
        }
        return str_replace(self::$deVietnameseSearches,
        self::$deVietnameseReplaces, $str);
    }

    /**
     * Detects Vietnamese tone mark from a single letter.
     *
     * @param $letter char
     * @return int see {@link Ddth_Vnvi_Constants Constants} class for list of tone marks
     */
    public function getLetterToneMark($letter) {
        if ( isset(self::$tblToneMarkMapping[$letter]) ) {
            return self::$tblToneMarkMapping[$letter];
        }
        return Ddth_Vnvi_Constants::MARK_NONE;
    }

    /**
     * Detects Vietnamese tone mark from a word.
     * 
     * Note: if word has more than 1 tone mark (which is not spelling-correct), only
     * the first tone mark is counted, all other tone marks are discarded.
     *
     * @param $word string
     * @return int see {@link Ddth_Vnvi_Constants Constants} class for list of tone marks
     */
    public function getWordToneMark($word) {
        if ( !is_string($word) ) {
            return Ddth_Vnvi_Constants::MARK_NONE;
        }
        $mark = Ddth_Vnvi_Constants::MARK_NONE;
        $len = mb_strlen($word);
        while ( $len ) {
            $letter = mb_substr($word, 0, 1, self::ENCODING);
            $mark = $this->getLetterToneMark($letter);
            if ( $mark !== Ddth_Vnvi_Constants::MARK_NONE ) {
                break;
            }
            $word = mb_substr($word, 1, $len, self::ENCODING);
            $len = mb_strlen($word);
        }
        return $mark;
    }

    /**
     * Removes tone marks from a string.
     *
     * @param string
     * @return string the string after removing tone marks
     */
    public function removeToneMarks($str) {
        if ( !is_string($str) ) {
            return $str;
        }
        return str_replace(self::$toneMarkRemovalSearches,
        self::$toneMarkRemovalReplaces, $str);
    }

    /**
     * Makes a string lower-case.
     *
     * @param string
     * @return string the string after lower-cased
     */
    public function toLower($str) {
        if ( !is_string($str) ) {
            return $str;
        }
        return str_replace(self::$tblAllLettersUpper, self::$tblAllLettersLower, $str);
    }

    /**
     * Makes a string upper-case.
     *
     * @param string
     * @return string the string after upper-cased
     */
    public function toUpper($str) {
        if ( !is_string($str) ) {
            return $str;
        }
        return str_replace(self::$tblAllLettersLower, self::$tblAllLettersUpper, $str);
    }
}
?>