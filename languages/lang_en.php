<?php
require_once 'includes/denyDirectInclude.php';
$LANG = Array();

//for NcodeImageResizer
$LANG['ncode_imageresizer_warning_small'] = 'Click this bar to view the full image.';
$LANG['ncode_imageresizer_warning_filesize'] = 'This image has been resized. Click this bar to view the full image. The original image is sized %1$sx%2$s and weights %3$sKB.';
$LANG['ncode_imageresizer_warning_no_filesize'] = 'This image has been resized. Click this bar to view the full image. The original image is sized %1$sx%2$s.';
$LANG['ncode_imageresizer_warning_fullsize'] = 'Click this bar to view the small image.';

$LANG['LOGIN_NAME'] = 'Login Name';
$LANG['PASSWORD'] = 'Password';
$LANG['CURRENT_PASSWORD'] = 'Current Password';
$LANG['NEW_PASSWORD'] = 'New Password';
$LANG['CONFIRMED_NEW_PASSWORD'] = 'Confirmed New Password';
$LANG['CONFIRMED_PASSWORD'] = 'Confirmed Password';
$LANG['LOGIN'] = 'Login';
$LANG['LOGOUT'] = 'Logout';
$LANG['UPDATE'] = 'Update';
$LANG['OK'] = 'Ok';
$LANG['CANCEL'] = 'Cancel';
$LANG['YES'] = 'Yes';
$LANG['NO'] = 'No';
$LANG['ACTIONS'] = 'Actions';
$LANG['EDIT'] = 'Edit';
$LANG['DELETE'] = 'Delete';
$LANG['MOVE_UP'] = 'Up';
$LANG['MOVE_DOWN'] = 'Down';
$LANG['CHANGE'] = 'Change';
$LANG['REGISTER'] = 'Register';
$LANG['REGISTER_DONE'] = 'Congratulation! Account {0} has been created successfully. '
    .'However, you must activate your account before you are be able to login. '
    .'An email with instructions to activate your account has been sent to your email address.';
$LANG['GO_BACK'] = 'Go Back';
$LANG['SECURITY_CODE'] = 'Security Code';
$LANG['ACTIVATE_ACCOUNT'] = 'Activate Account';
$LANG['RESEND_ACTIVATION_CODE'] = 'Resend Activation Code';
$LANG['RESEND_ACTIVATION_CODE_DONE'] = 'An email with instructions to activate your account has been sent to your email address.';
$LANG['ANONYMOUS'] = 'Anonymous';

$LANG['REGISTER_EMAIL_SUBJECT'] = 'Account registration confirmation';
$LANG['REGISTER_EMAIL_BODY'] = "You have registered an account at {SITE} with the following information:
Login Name: {LOGIN_NAME}
Full Name: {FULL_NAME}

Please confirm your registration by visiting the following link {URL_ACTIVATE_ACCOUNT}.

Note: Please do not respond directly to this email as it is an unattended mail box!
If you have any question or inquiry, please contact the web site's administrator at {EMAIL_ADMINISTRATOR}";

$LANG['ADS_MANAGEMENT'] = 'Ads Management';
$LANG['MY_ADS'] = 'My ads';
$LANG['POST_ADS'] = 'Post to classifieds';
$LANG['ATTACH_IMAGES'] = 'Attach Images';
$LANG['ALLOWED_UPLOAD_FILE_TYPES'] = 'Allowed file types';
$LANG['MAX_UPLOAD_SIZE'] = 'Maximum upload size';

$LANG['ADS_LOCATION'] = 'City/Province';
$LANG['ADS_PRICE'] = 'Price';
$LANG['ADS_PRICE_CONTACT'] = 'Contact';
$LANG['ADS_PRICE_FREE'] = 'Free';
$LANG['ADS_PRICE_SPECIFY'] = 'Specify';
$LANG['ADS_TYPE'] = 'Type';
$LANG['ADS_TYPE_SELL'] = 'Sell';
$LANG['ADS_TYPE_BUY'] = 'Buy';
$LANG['ADS_TITLE'] = 'Title';
$LANG['ADS_CONTENT'] = 'Content';
$LANG['ADS_EXPIRY'] = 'Expiry';
$LANG['ADS_POST_BY'] = 'Post by';
$LANG['ADS_POST_DATE'] = 'Post date';
$LANG['ADS_NUM_VIEWS'] = 'Num Views';
$LANG['ADS_CONTACT_POSTER'] = 'Contact poster';
$LANG['ADS_CONTACT_POSTER_DONE'] = 'Your message has been sent to poster of this ads';
$LANG['ADS_CONTACT_POSTER_OF'] = 'Contact poster of';
$LANG['ADS_LOGIN_TO_CONTACT_POSTER'] = 'Please login to contact poster';

$LANG['ADS_CONTACT_POSTER_NAME'] = 'Your name';
$LANG['ADS_CONTACT_POSTER_EMAIL'] = 'Your email';
$LANG['ADS_CONTACT_POSTER_CONTENT'] = 'Message to send';

$LANG['ADS_CONTACT_POSTER_EMAIL_SUBJECT'] = 'New contact for your ads';
$LANG['ADS_CONTACT_POSTER_EMAIL_BODY'] = '{0} has sent you a message regarding to your ads: {1}.';

$LANG['ADS_REPORT_ADMIN'] = 'Report ads to admin';
$LANG['ADS_REPORT_ADMIN_CONFIRMATION'] = 'You may use this function to report bad ads to administrators. Are you sure you want to report this ads?';
$LANG['ADS_REPORT_ADMIN_DONE'] = 'Ads has been reported to administrators';

$LANG['WELCOME'] = 'Welcome {0}!';

$LANG['HOME'] = 'Home';
$LANG['MY_PROFILE'] = 'My Profile';
$LANG['ADMIN_SECTION'] = 'Administration Section';

$LANG['USER_ID'] = 'User Id';
$LANG['LOGIN_NAME'] = 'Login Name';
$LANG['EMAIL'] = 'Email';
$LANG['NEW_EMAIL'] = 'New Email';
$LANG['COFIRMED_NEW_EMAIL'] = 'Confirmed New Email';
$LANG['FULL_NAME'] = 'Full name';
$LANG['NEW_FULL_NAME'] = 'New full name';

$LANG['REPORTED_ADS'] = 'Reported Ads';

$LANG['CATEGORY'] = 'Category';
$LANG['CATEGORY_NAME'] = 'Name';
$LANG['CATEGORY_DESCRIPTION'] = 'Description';
$LANG['CATEGORY_PARENT'] = 'Parent';

$LANG['ADMIN_CATEGORY_MANAGEMENT'] = 'Category Management';
$LANG['ADMIN_CREATE_CATEGORY'] = 'Create Category';
$LANG['ADMIN_NUMBER_OF_CATEGORIES'] = 'Number of categories';
$LANG['ADMIN_NUMBER_OF_ADS'] = 'Total number of ads';
$LANG['ADMIN_NUMBER_OF_EXPIRED_ADS'] = 'Total number of expired ads';
$LANG['ADMIN_NUMBER_OF_REPORTED_ADS'] = 'Total number of reported ads';
$LANG['ADMIN_NUMBER_OF_USERS'] = 'Number of user accounts';
$LANG['ADMIN_DELETE_EXPIRED_ADS'] = 'Delete expired ads';
$LANG['ADMIN_VIEW_REPORTED_ADS'] = 'View reported ads';

$LANG['CONFIRM_DELETE_CATEGORY'] = 'Are you sure you want to delete the following category?';
$LANG['CONFIRM_DELETE_ADS'] = 'Are you sure you want to delete the following ads?';

$LANG['ADMIN_TITLE'] = 'Administration Section';
$LANG['ADMIN_TITLE_LOGIN'] = 'Login';
$LANG['ADMIN_TITLE_INDEX'] = 'Site Statistics';
$LANG['ADMIN_TITLE_CREATE_CATEGORY'] = 'Create New Category';
$LANG['ADMIN_TITLE_DELETE_CATEGORY'] = 'Delete Category';
$LANG['ADMIN_TITLE_EDIT_CATEGORY'] = 'Edit Category';
$LANG['ADMIN_TITLE_CATEGORY_MANAGEMENT'] = 'Category Management';
$LANG['ADMIN_TITLE_REPORTED_ADS'] = 'Reported Ads';
$LANG['ADMIN_TITLE_PROCESS_REPORTED_ADS'] = 'Process Reported Ads';

$LANG['MY_PROFILE_TITLE'] = 'My Profile';
$LANG['MY_PROFILE_TITLE_LOGIN'] = 'Login';
$LANG['MY_PROFILE_TITLE_INDEX'] = 'Summary';
$LANG['MY_PROFILE_TITLE_CHANGE_EMAIL'] = 'Change Email';
$LANG['MY_PROFILE_TITLE_CHANGE_FULL_NAME'] = 'Change Full Name';
$LANG['MY_PROFILE_TITLE_CHANGE_PASSWORD'] = 'Change Password';
$LANG['MY_PROFILE_TITLE_POST_ADS'] = 'Post Ads To Classifieds';
$LANG['MY_PROFILE_TITLE_MY_ADS'] = 'My Ads';
$LANG['MY_PROFILE_TITLE_EDIT_MY_ADS'] = 'Edit Ads';
$LANG['MY_PROFILE_TITLE_DELETE_MY_ADS'] = 'Delete Ads';

$LANG['MY_PROFILE_MANAGEMENT'] = 'My Profile Management';
$LANG['MY_PROFILE_CHANGE_EMAIL'] = 'Change Email';
$LANG['MY_PROFILE_CHANGE_FULL_NAME'] = 'Change Full Name';
$LANG['MY_PROFILE_CHANGE_PASSWORD'] = 'Change Password';

$LANG['NO_DATA_TO_DISPLAY'] = 'There is no data to display';

$LANG['ERROR_NO_PERMISSION'] = 'Error: You do not have permission to access this page!';
$LANG['ERROR_USER_NOT_FOUND'] = 'Error: User account not found!';
$LANG['ERROR_ACTIVATION_CODE_NOT_MATCH'] = 'Error: Activation code does not match!';
$LANG['ERROR_LOGIN_FAILED'] = 'Login failed: wrong login name or password!';
$LANG['ERROR_EMPTY_CATEGORY_NAME'] = 'Error: Category name is empty!';
$LANG['ERROR_CATEGORY_NOT_FOUND'] = 'Error: Category not found!';
$LANG['ERROR_CATEGORY_HAS_CHILDREN'] = 'Error: Action is not allowed - category contains sub-categories!';
$LANG['ERROR_EMAIL_NOT_MATCH'] = 'Error: Email address not match!';
$LANG['ERROR_PASSWORD_NOT_MATCH'] = 'Error: Password does not match!';
$LANG['ERROR_ACCOUNT_ALREADY_ACTIVATED'] = 'Error: Account has already been activated!';
$LANG['ERROR_ACCOUNT_NOT_ACTIVATED'] = 'Error: Account has not been activated!';
$LANG['ERROR_CONFIRMED_PASSWORD_NOT_MATCH'] = 'Error: Password does not match the confirmed one!';
$LANG['ERROR_SECURITY_CODE_NOT_MATCH'] = 'Error: Security Code does not match!';
$LANG['ERROR_EMPTY_NEW_PASSWORD'] = 'Error: New password is empty!';
$LANG['ERROR_EMPTY_NEW_FULL_NAME'] = 'Error: Full name is empty!';
$LANG['ERROR_EMPTY_NEW_EMAIL'] = 'Error: New email is empty!';
$LANG['ERROR_CONFIRMED_EMAIL_NOT_MATCH'] = 'Error: Email does not match the confirmed one!';
$LANG['ERROR_EMAIL_ALREADY_EXISTS'] = 'Error: This email has been registered by another user!';
$LANG['ERROR_LOGIN_NAME_ALREADY_EXISTS'] = 'Error: This login name has been registered by another user!';
$LANG['ERROR_EMPTY_LOGIN_NAME'] = 'Error: Login name is empty!';
$LANG['ERROR_EMPTY_PASSWORD'] = 'Error: Password is empty!';
$LANG['ERROR_EMPTY_EMAIL'] = 'Error: Email is empty!';
$LANG['ERROR_INVALID_CATEGORY_SELECTION'] = 'Error: Please select a valid category!';
$LANG['ERROR_EMPTY_ADS_TITLE'] = 'Error: Empty ads title!';
$LANG['ERROR_EMPTY_ADS_CONTENT'] = 'Error: Empty ads content!';
$LANG['ERROR_ADS_NOT_FOUND'] = 'Error: Ads not found!';
$LANG['ERROR_EMPTY_ADS_CONTACT_POSTER_NAME'] = 'Error: Please enter your name!';
$LANG['ERROR_EMPTY_ADS_CONTACT_POSTER_EMAIL'] = 'Error: Please enter your email address!';
$LANG['ERROR_EMPTY_ADS_CONTACT_POSTER_CONTENT'] = 'Error: Please enter message to send!';
$LANG['ERROR_UPLOAD_FILE_NOT_ALLOWED'] = 'Error: File "{0}" is not allowed to upload!';
$LANG['ERROR_UPLOAD_TOTAL_SIZE_TOO_LARGE'] = 'Error: Total upload size ({0} bytes) exceeds the allowed value ({1} bytes)!';
$LANG['ERROR_UPLOAD_SIZE_TOO_LARGE_PHP_INI'] = 'Error: Upload size is too large!';
$LANG['ERROR_UPLOAD_SIZE_TOO_LARGE_FORM'] = 'Error: Upload size exceeds {0} bytes!';
$LANG['ERROR_UPLOAD_GENERAL'] = 'Error: There was a network error while uploading file(s)!';

$LANG['INFO_PASSWORD_CHANGED'] = 'Information: Password has been changed successfully!';
$LANG['INFO_FULL_NAME_CHANGED'] = 'Information: Full name has been changed successfully!';
$LANG['INFO_EMAIL_CHANGED'] = 'Information: Email has been changed successfully!';
$LANG['INFO_FILES_UPLOADED'] = 'Information: {0} file(s) uploaded!';
$LANG['INFO_ATTACHMENTS_DELETED'] = 'Information: {0} attachment(s) deleted!';
$LANG['INFO_ACCOUNT_ACTIVATED'] = 'Information: Account {0} has been activated successfully!';
?>