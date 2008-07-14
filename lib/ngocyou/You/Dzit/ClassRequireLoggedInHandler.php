<?php
abstract class You_Dzit_RequireLoggedInHandler extends You_Dzit_BaseActionHandler {
    protected function requiredLoggedIn() {
        return true;
    }
}
?>