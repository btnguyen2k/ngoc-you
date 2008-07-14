<?php
class You_DataModel_Form {
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $action = '';

    /**
     * @var string
     */
    private $cancelAction = '';

    /**
     * @var Array
     */
    private $fields = Array();

    /**
     * @var string
     */
    private $captchaUrl = '';

    /**
     * @var Array
     */
    private $errorMessages = Array();

    public function __construct($name=NULL, $action=NULL, $cancelAction=NULL, $captchaUrl=NULL) {
        $this->setName($name);
        $this->setAction($action);
        $this->setCancelAction($cancelAction);
        $this->setCaptchaUrl($captchaUrl);
    }

    public function setAction($action=NULL) {
        $this->action = trim(isset($action) ? $action : NULL);
    }

    public function getAction() {
        return $this->action;
    }

    public function setCancelAction($action=NULL) {
        $this->cancelAction = trim(isset($action) ? $action : NULL);
    }

    public function getCancelAction() {
        return $this->cancelAction;
    }

    public function getCaptchaUrl() {
        return $this->captchaUrl;
    }

    public function setCaptchaUrl($url=NULL) {
        $this->captchaUrl = trim(isset($url) ? $url : NULL);
    }

    public function setName($name=NULL) {
        $this->name = trim(isset($name) ? $name : NULL);
    }

    public function getName() {
        return $this->name;
    }

    public function setField($name, $value) {
        $this->fields[$name] = $value;
    }

    public function getField($name) {
        return isset($this->fields[$name]) ? $this->fields[$name] : '';
    }

    public function hasErrorMessage() {
        return count($this->errorMessages) > 0;
    }

    public function hasErrorMessages() {
        return $this->hasErrorMessage();
    }

    public function numErrorMessages() {
        return count($this->errorMessages);
    }

    public function getErrorMessages() {
        return $this->errorMessages;
    }

    public function getErrorMessage($index) {
        return isset($this->errorMessages[$index]) ? $this->errorMessages[$index] : "";
    }

    public function addErrorMessage($msg) {
        $this->errorMessages[] = $msg;
    }
}
?>