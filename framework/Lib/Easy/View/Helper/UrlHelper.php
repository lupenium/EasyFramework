<?php

class UrlHelper extends AppHelper {

    /**
     * Converts a virtual (relative) path to an application absolute path.
     * @param string $string The path to convert
     * @return string An absolute url to the path
     */
    public function content($string, $full = true) {
        return Mapper::url($string, $full);
    }

    /**
     * Generates a fully qualified URL to an action method by using the specified action name and controller name.
     * @param string $actionName The action Name
     * @param string $controllerName The controller Name
     * $param mixed $params The params to the action
     * @return string An absolute url to the action
     */
    public function action($actionName, $controllerName = null, $params = null) {
        if ($controllerName === true) {
            $controllerName = strtolower($this->view->getController()->getName());
        }
        return Mapper::url(array(
                    'controller' => urlencode($controllerName),
                    'action' => urlencode($actionName),
                    $params
                        ), true);
    }

    /**
     * Gets the base url to your application
     * @return string The base url to your application 
     */
    public function getBase() {
        return Mapper::base();
    }

}