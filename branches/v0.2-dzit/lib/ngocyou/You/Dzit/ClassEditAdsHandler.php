<?php
require_once 'dao/dbUtils.php';
class You_Dzit_EditAdsHandler extends You_Dzit_RequireLoggedInHandler {

    const DATAMODEL_ADS                          = 'ads';
    const DATAMODEL_NAVIGATOR                    = 'navigator';
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
    const FORM_FIELD_ADS_DELETE_ATTACHMENT       = 'adsDeleteAttachment';

    private $form = NULL;
    private $ads  = NULL;

    private function checkUploadFiles($form, $maxUploadFiles, $maxUploadSize) {
        $uploadFiles = Array();
        $ads = $this->ads;
        if ( $maxUploadFiles - $ads->countAttachments() > 0 && count($_FILES) > 0 ) {
            $app = $this->getApplication();
            $lang = $this->getLanguage();
            $totalSize = $ads->countAttachmentSize(); //total size of existing attachments
            $fileTypes = getConfig(You_Dzit_Constants::CONFIG_ALLOWED_UPLOAD_FILE_TYPES);
            $allowedFileTypes = preg_split('/[\s,;|]+/', strtolower(trim($fileTypes)));

            for ( $i = 0; $i < count($allowedFileTypes); $i++ ) {
                //normalize file types
                $allowedFileTypes[$i] = '.'.preg_replace('/^\.+/', '', $allowedFileTypes[$i]);
            }
            //check upload files
            for ( $i = 0; $i < $maxUploadFiles - $ads->countAttachments(); $i++ ) {
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
        $id = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $this->ads = getEntry($id);
        $app = $this->getApplication();
        $lang = $this->getLanguage();
        if ( $this->ads === NULL ) {
            $msg = $lang->getMessage('error.adsNotFound');
            $app->setAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE, $msg);
            return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_ERROR);
        }
        $user = $app->getCurrentUser();
        if ( $this->ads->getUserId() !== $user->getId() ) {
            $msg = $lang->getMessage('error.noPermission');
            $app->setAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE, $msg);
            return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_ERROR);
        }
        $this->populateDataModels();
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $form = $this->form;
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
                $maxUploadFiles = getConfig(You_Dzit_Constants::CONFIG_MAX_UPLOAD_FILES);
                $maxUploadSize = getConfig(You_Dzit_Constants::CONFIG_MAX_UPLOAD_SIZE);
                $uploadFiles = $this->checkUploadFiles($form, $maxUploadFiles, $maxUploadSize);
            }
            if ( !$form->hasErrorMessage() ) {
                $deleteAttachments = Array();
                foreach ( $this->ads->getAllAttachments() as $upload ) {
                    $id = self::FORM_FIELD_ADS_DELETE_ATTACHMENT.$upload->getId();
                    if ( isset($_POST[$id]) ) {
                        $deleteAttachments[] = $upload;
                    }
                }
                deleteAttachmentsFromEntry($this->ads, $deleteAttachments);
                addUploadFilesToEntry($this->ads, $uploadFiles);
                if ( count($deleteAttachments) > 0 ) {
                    $form->addErrorMessage($lang->getMessage('ads.attachment.deleted', count($deleteAttachments)));
                }
                if ( count($uploadFiles) > 0 ) {
                    $form->addErrorMessage($lang->getMessage('ads.attachment.added', count($uploadFiles)));
                }

                $this->ads->setIsHtml($form->getField('html'));
                $this->ads->setCategoryId($catId);
                $this->ads->setCategory($cat);
                $this->ads->setTitle($adsTitle);
                $this->ads->setContent(removeEvilHtmlTags($adsContent));
                $this->ads->setType($adsType);
                $this->ads->setPrice($adsPrice);
                $this->ads->setLocation($adsLocation);
                updateEntry($this->ads);
				reindexEntry($this->ads);

				if ( count($deleteAttachments) > 0 || count($uploadFiles) > 0 ) {
                    $msg = $lang->getMessage('ads.attachment.changed', Array('DELETED'=>count($deleteAttachments), 'ADDED'=>count($uploadFiles)));
                    $transmission = $app->createTransmission($msg);
                    $urlCreator = $app->getUrlCreator();
                    $urlParams = Array('id' => $this->ads->getId(), Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION=>$transmission->getId());
                    $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_EDIT_ADS, Array(), $urlParams);
                    return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
                } else {
                    $msg = $lang->getMessage('ads.edit.done');
                    $transmission = $app->createTransmission($msg);
                    $urlCreator = $app->getUrlCreator();
                    $urlParams = Array(Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION=>$transmission->getId());
                    $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MY_ADS, Array(), $urlParams);
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
            $form = new You_DataModel_Form('frmEditAds');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $urlParams = Array('id' => $this->ads->getId());
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_EDIT_ADS, Array(), $urlParams));
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
            $form->setField($field, $this->ads->getCategoryId());

            $field = self::FORM_FIELD_ADS_TYPE;
            $form->setField($field, $this->ads->getType());

            $field = self::FORM_FIELD_ADS_PRICE;
            $form->setField($field, $this->ads->getPrice());

            $field = self::FORM_FIELD_ADS_LOCATION;
            $form->setField($field, $this->ads->getLocation());

            $field = self::FORM_FIELD_ADS_TITLE;
            $form->setField($field, $this->ads->getTitle());

            $field = self::FORM_FIELD_ADS_CONTENT;
            $form->setField($field, $this->ads->getContent());
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
        $app = $this->getApplication();
        $lang = $app->getLanguage();
        $urlCreator = $app->getUrlCreator();

        /* ads */
        $node->addChild(self::DATAMODEL_ADS, new You_DataModel_Ads($this->ads));

        /* category tree */
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);

        /* navigator */
        $model = Array();
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('myprofile'), $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MYPROFILE));
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('member.myAds'), $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MY_ADS));
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('ads.edit'));
        $node->addChild(self::DATAMODEL_NAVIGATOR, $model);

        /* locations */
        $locationNode = new Ddth_Template_DataModel_List(self::DATAMODEL_ADS_LOCATION_LIST);
        $node->addChild(self::DATAMODEL_ADS_LOCATION_LIST, $locationNode);
        $locations = getAllLocations();
        foreach ( $locations as $k=>$v ) {
            $locationNode->addChild(new Ddth_Template_DataModel_Map('', Array('key'=>$k, 'value'=>$v)));
        }

        /* some configuration settings */
        $node->addChild(self::DATAMODEL_ADS_MAX_UPLOAD_FILES, getConfig(You_Dzit_Constants::CONFIG_MAX_UPLOAD_FILES));
        $node->addChild(self::DATAMODEL_ADS_ALLOWED_UPLOAD_FILETYPES, getConfig(You_Dzit_Constants::CONFIG_ALLOWED_UPLOAD_FILE_TYPES));
        $node->addChild(self::DATAMODEL_ADS_MAX_UPLOAD_SIZE, getConfig(You_Dzit_Constants::CONFIG_MAX_UPLOAD_SIZE));
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageHeaderTitle()}
     */
    protected function populateModelPageHeaderTitle($pageHeader) {
        $app = $this->getApplication();
        $lang = $app->getLanguage();
        $title = $lang->getMessage('ads.edit') . ': ';
        $title .= $this->ads->getTitle() . ' - ' . getConfig(You_Dzit_Constants::CONFIG_SITE_NAME);
        $pageHeader->addChild(Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_HEADER_TITLE, $title);
    }
}
?>
