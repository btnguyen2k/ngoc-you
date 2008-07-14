<?php
require_once 'dao/dbUtils.php';
class You_Dzit_PostAdsHandler extends You_Dzit_AdminHandler {

    const DATAMODEL_CATEGORY_TREE                = 'categoryTree';
    const DATAMODEL_ADS_LOCATION_LIST            = 'adsLocationList';
    const DATAMODEL_ADS_MAX_UPLOAD_FILES         = 'adsMaxUploadFiles';
    const DATAMODEL_ADS_MAX_UPLOAD_SIZE          = 'adsMaxUploadSize';
    const DATAMODEL_ADS_ALLOWED_UPLOAD_FILETYPES = 'adsAllowedUploadFiletypes';

    const FORM_FIELD_CATEGORY_ID                 = 'categoryId';
    const FORM_FIELD_ADS_TYPE                    = 'adsType';
    const FORM_FIELD_ADS_PRICE                   = 'adsPrice';
    const FORM_FIELD_ADS_LOCATION                = 'adsLocation';
    const FORM_FIELD_ADS_TITLE                   = 'adsTitle';
    const FORM_FIELD_ADS_CONTENT                 = 'adsContent';
    const FORM_FIELD_ADS_ATTACHMENT              = 'adsAttachment';

    private $form;

    private function checkUploadFiles($form, $maxUploadFiles, $maxUploadSize) {
        $uploadFiles = Array();
        if ( $maxUploadFiles > 0 && count($_FILES) > 0 ) {
            $app = $this->getApplication();
            $lang = $this->getLanguage();
            $totalSize = 0;
            $fileTypes = $app->getYouProperty('you.upload.allowedFiletypes');
            $allowedFileTypes = preg_split('/[\s,;|]+/', strtolower(trim($fileTypes)));

            for ( $i = 0; $i < count($allowedFileTypes); $i++ ) {
                //normalize file types
                $allowedFileTypes[$i] = '.'.preg_replace('/^\.+/', '', $allowedFileTypes[$i]);
            }
            //check upload files
            for ( $i = 0; $i < $maxUploadFiles; $i++ ) {
                $token = self::FORM_FIELD_ADS_ATTACHMENT.$i;
                if ( !isset($_FILES[$token]) || $_FILES[$token]['error']===4 ) {
                    continue;
                }
                $fileName = strtolower($_FILES[$token]['name']);
                $allowed = false;
                foreach ( $allowedFileTypes as $type ) {
                    if ( substr($fileName, strlen($fileName)-strlen($type)) === $type ) {
                        $allowed = true;
                        break;
                    }
                }
                if  ( !$allowed ) {
                    $msg = $lang->getMessage('error.uploadFileNotAllowed', $fileName);
                    $form->addErrorMessage($msg);
                    break;
                }
                if ( $_FILES[$token]['error']===3 ) {
                    $form->addErrorMessage($lang->getMessage('error.uploadGeneral'));
                    break;
                }
                if ( $_FILES[$token]['error']===1 ) {
                    $form->addErrorMessage($lang->getMessage('error.uploadSizeTooLargePhpIni'));
                    break;
                }
                if ( $_FILES[$token]['error']===2 ) {
                    $form->addErrorMessage($lang->getMessage('error.uploadSizeTooLargeForm'), Array($_POST['MAX_FILE_SIZE']));
                    break;
                }

                $totalSize += $_FILES[$token]['size'];
                if ( $totalSize > $maxUploadSize ) {
                    $msg = $lang->getMessage('error.uploadTotalSizeTooLarge', Array($totalSize, $maxUploadSize));
                    $form->addErrorMessage($msg);
                    break;
                }

                $uploadFiles[] = $_FILES[$token];
            }
        }
        return $uploadFiles;
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $form = $this->form;
            $app = $this->getApplication();
            $lang = $this->getLanguage();
            $uploadFiles = Array();
            $catId = $form->getField(self::FORM_FIELD_CATEGORY_ID);
            $adsTitle = $form->getField(self::FORM_FIELD_ADS_TITLE);
            $adsContent = $form->getField(self::FORM_FIELD_ADS_CONTENT);
            $adsLocation = $form->getField(self::FORM_FIELD_ADS_LOCATION);
            $adsType = $form->getField(self::FORM_FIELD_ADS_TYPE);
            $adsPrice = $form->getField(self::FORM_FIELD_ADS_PRICE);
            $cat = getCategory($catId);
            if ( $cat === NULL ) {
                $form->addErrorMessage($lang->getMessage('error.invalidCategorySelection'));
            } elseif ( $adsTitle === '' ) {
                $form->addErrorMessage($lang->getMessage('error.emptyAdsTitle'));
            } elseif ( $adsContent === '' ) {
                $form->addErrorMessage($lang->getMessage('error.emptyAdsContent'));
            } else {
                $urlCreator = $app->getUrlCreator();
                $maxUploadFiles = $app->getYouProperty('you.upload.max.files');
                $maxUploadSize = $app->getYouProperty('you.upload.max.size');
                $uploadFiles = $this->checkUploadFiles($form, $maxUploadFiles, $maxUploadSize);
                if ( !$form->hasErrorMessage() ) {
                    $expiry = 7*24*3600; //expires in 7 days!
                    $params = Array(
                		'category' => $cat,
                		'user'        => $app->getCurrentUser(),
                        'expiry'      => $expiry,
                        'adsTitle'    => $adsTitle,
                    	'adsContent'  => removeEvilHtmlTags($adsContent),
                    	'adsType'     => $adsType,
                    	'adsPrice'    => $adsPrice,
                    	'adsLocation' => $adsLocation,
                        'html'        => $form->getField('html')
                    );
                    $newEntry = createEntry($params);
                    addUploadFilesToEntry($newEntry, $uploadFiles);

                    //notify watchers
                    $emailSubject = $lang->getMessage('email.adsWatch.subject');
                    $urlAds = $urlCreator->createUrl(You_Dzit_Constants::ACTION_VIEW_ADS, Array(), Array('id'=>$newEntry->getId()), "", true);
                    $emailAdmin = $app->getYouProperty('you.administrator.email');
                    $emailOutgoing = $app->getYouProperty('you.email.outgoing');
                    $replacements = Array(
                        'ADS_TITLE'           => $adsTitle,
                        'CATEGORY_NAME'       => $cat->getName(),
                        'URL_ADS'		      => $urlAds,
                        'EMAIL_ADMINISTRATOR' => $emailAdmin,
                    	'EMAIL_OUTGOING'      => $emailOutgoing,
                    );
                    $emailBody = $lang->getMessage('email.adsWatch.body', $replacements);
                    $watchers = getWatcherList($cat);
                    foreach ( $watchers as $user ) {
                        sendEmail($emailOutgoing, $user->getEmail(), $emailSubject, $emailBody, true);
                    }
                    $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MY_ADS);
                    return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
                }
            }
        }
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageForm()}
     */
    protected function populateModelPageForm($page) {
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_FORM;
        $node = $page->getChild($name);
        $form = NULL;
        if ( $node === NULL ) {
            $form = new You_DataModel_Form('frmPostAds');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_POST_ADS));
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MY_ADS));

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_CATEGORY_ID;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);

            $field = self::FORM_FIELD_ADS_TYPE;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);

            $field = self::FORM_FIELD_ADS_PRICE;
            $value = isset($_POST[$field]) ? (trim($_POST[$field])!=='' ? $_POST[$field]+0 : NULL) : NULL;
            $form->setField($field, $value);

            $field = self::FORM_FIELD_ADS_LOCATION;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);

            $field = self::FORM_FIELD_ADS_TITLE;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_ADS_CONTENT;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = 'html';
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);
        } else {
            $field = self::FORM_FIELD_CATEGORY_ID;
            $form->setField($field, 0);

            $field = self::FORM_FIELD_ADS_TYPE;
            $form->setField($field, 0);

            $field = self::FORM_FIELD_ADS_PRICE;
            $form->setField($field, '');

            $field = self::FORM_FIELD_ADS_LOCATION;
            $form->setField($field, 0);

            $field = self::FORM_FIELD_ADS_TITLE;
            $form->setField($field, '');

            $field = self::FORM_FIELD_ADS_CONTENT;
            $form->setField($field, '');
        }
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageContent()}
     */
    protected function populateModelPageContent($page) {
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_CONTENT;
        $node = $page->getChild($name);
        if ( $node === NULL ) {
            $node = new Ddth_Template_DataModel_Map($name);
            $page->addChild($name, $node);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, getCategoryTree());
        $locationNode = new Ddth_Template_DataModel_List(self::DATAMODEL_ADS_LOCATION_LIST);
        $node->addChild(self::DATAMODEL_ADS_LOCATION_LIST, $locationNode);
        $locations = getAllLocations();
        foreach ( $locations as $k=>$v ) {
            $locationNode->addChild(new Ddth_Template_DataModel_Map('', Array('key'=>$k, 'value'=>$v)));
        }

        $app = $this->getApplication();
        $node->addChild(self::DATAMODEL_ADS_MAX_UPLOAD_FILES, $app->getYouProperty('you.upload.max.files'));
        $node->addChild(self::DATAMODEL_ADS_ALLOWED_UPLOAD_FILETYPES, $app->getYouProperty('you.upload.allowedFiletypes'));
        $node->addChild(self::DATAMODEL_ADS_MAX_UPLOAD_SIZE, $app->getYouProperty('you.upload.max.size'));
    }
}
?>
