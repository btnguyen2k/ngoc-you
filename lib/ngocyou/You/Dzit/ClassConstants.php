<?php
class You_Dzit_Constants {   
    const CONFIG_SITE_NAME				    = 'SITE_NAME';
    const CONFIG_SITE_TITLE			        = 'SITE_TITLE';
    const CONFIG_SITE_KEYWORDS			    = 'SITE_KEYWORDS';
    const CONFIG_SITE_DESCRIPTION		    = 'SITE_DESCRIPTION';
    const CONFIG_MAX_UPLOAD_FILES           = 'MAX_UPLOAD_FILES';
    const CONFIG_MAX_UPLOAD_SIZE		    = 'MAX_UPLOAD_SIZE';
    const CONFIG_ALLOWED_UPLOAD_FILE_TYPES  = 'ALLOWED_UPLOAD_FILE_TYPES';
    const CONFIG_EMAIL_OUTGOING			    = 'EMAIL_OUTGOING';
    const CONFIG_EMAIL_ADMINISTRATOR        = 'EMAIL_ADMINISTRATOR';
    const CONFIG_TEMPLATE_URI               = 'TEMPLATE_URI';
    const CONFIG_DATE_FORMAT                = 'DATE_FORMAT';
    const CONFIG_DATETIME_FORMAT            = 'DATETIME_FORMAT';    
    const CONFIG_CATEGORY_NUM_TOP           = 'NUM_TOP_CATEGORIES';
    const CONFIG_ADS_EXPIRY_DAYS            = 'ADS_EXPIRY_DAYS';
    const CONFIG_AUTO_DELETE_EXPIRED_ADS    = 'AUTO_DELETE_EXPIRED_ADS';
    const CONFIG_CUSTOM_PAGE_CONTENT_LEFT   = 'CUSTOM_CONTENT_LEFT';
    const CONFIG_CUSTOM_PAGE_CONTENT_RIGHT  = 'CUSTOM_CONTENT_RIGHT';
    const CONFIG_CUSTOM_PAGE_CONTENT_TOP    = 'CUSTOM_CONTENT_TOP';
    const CONFIG_CUSTOM_PAGE_CONTENT_BOTTOM = 'CUSTOM_CONTENT_BOTTOM';
    
    const SESSION_LAST_ACCESS_PAGE       = 'LAST_ACCESS_PAGE';
    const SESSION_CURRENT_USER_ID        = 'CURRENT_USER_ID';
    
    const APP_ATTR_ERROR_MESSAGE         = 'ERROR_MESSAGE';
    
    const DATA_MODEL_FORM = 'form';
    
    const ACTION_INDEX                   = 'index';
    const ACTION_DEFAULT                 = 'index';
    const ACTION_CAPTCHA                 = 'captcha';
    const ACTION_LOGIN                   = 'login';
    const ACTION_LOGOUT                  = 'logout';
    const ACTION_ERROR                   = 'error';
    const ACTION_SEARCH                  = 'search';
    const ACTION_SEARCH_RESULT           = 'searchResult';
    const ACTION_RSS                     = 'rss';
    
    const ACTION_VIEW_ADS                = 'viewAds';
    const ACTION_DELETE_ADS              = 'deleteAds';
    const ACTION_EDIT_ADS                = 'editAds';
    const ACTION_REPORT_ADS              = 'reportAds';
    const ACTION_VIEW_CATEGORY           = 'viewCat';
    const ACTION_CONTACT_POSTER          = 'contactPoster';
    const ACTION_ATTACHMENT_THUMBNAIL    = 'thumbAttachment';
    const ACTION_ATTACHMENT_VIEW         = 'viewAttachment';
    
    const ACTION_ADMIN_CP                  = 'adminCp';
    const ACTION_ADMIN_CREATE_CATEGORY     = 'adminCreateCategory';
    const ACTION_ADMIN_EDIT_CATEGORY       = 'adminEditCategory';
    const ACTION_ADMIN_DELETE_CATEGORY     = 'adminDeleteCategory';
    const ACTION_ADMIN_CATEGORY_LIST       = 'adminCategoryList';
    const ACTION_ADMIN_DELETE_EXPIRED_ADS  = 'adminDeleteExpiredAds';
    const ACTION_ADMIN_VIEW_REPORTED_ADS   = 'adminViewReportedAds';
    const ACTION_ADMIN_REVIEW_REPORTED_ADS = 'adminReviewReportedAds';
    const ACTION_ADMIN_DELETE_REPORTED_ADS = 'adminDeleteReportedAds';
    const ACTION_ADMIN_UNREPORT_ADS        = 'adminUnreportAds';
    const ACTION_ADMIN_EMAIL_SETTINGS      = 'adminEmailSettings';
    
    const ACTION_MEMBER_REGISTER                    = 'register';
    const ACTION_MEMBER_REGISTER_DONE               = 'registerDone';
    const ACTION_MEMBER_FORGOT_PASSWORD             = 'forgotPassword';
    const ACTION_MEMBER_FORGOT_PASSWORD_DONE        = 'forgotPasswordDone';
    const ACTION_MEMBER_RESET_PASSWORD              = 'resetPassword';
    const ACTION_MEMBER_RESEND_ACTIVATION_CODE      = 'resendActivationCode';
    const ACTION_MEMBER_RESEND_ACTIVATION_CODE_DONE = 'resendActivationCodeDone';
    const ACTION_MEMBER_ACTIVATE_ACCOUNT            = 'activateAccount';
    const ACTION_MEMBER_MYPROFILE                   = 'myprofile';
    const ACTION_MEMBER_CHANGE_EMAIL                = 'changeEmail';
    const ACTION_MEMBER_CHANGE_FULL_NAME            = 'changeFullName';
    const ACTION_MEMBER_CHANGE_PASSWORD             = 'changePassword';
    const ACTION_MEMBER_MY_ADS                      = 'myAds';
    const ACTION_MEMBER_POST_ADS                    = 'postAds';
    
    public static $BASED_ALLOWED_TAGS = Array('<a>', '<p>', '<div>', '<blockquote>',
    	'<b>', '<strong>', '<i>', '<em>', '<u>', '<strike>', '<del>',
		'<font>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<h7>',
		'<sup>', '<sub>',
		'<ul>', '<ol>', '<li>',
		'<img>', '<br>',
		'<table>', '<thead>', '<th>', '<tbody>', '<tr>', '<td>'
    );
    public static $ADMIN_ALLOWED_TAGS = Array('<a>', '<p>', '<div>', '<blockquote>',
    	'<b>', '<strong>', '<i>', '<em>', '<u>', '<strike>', '<del>',
		'<font>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<h7>',
		'<sup>', '<sub>',
		'<ul>', '<ol>', '<li>',
		'<img>', '<br>',
		'<table>', '<thead>', '<th>', '<tbody>', '<tr>', '<td>',
        '<object>', '<embed>', '<param>'
    );
}
?>