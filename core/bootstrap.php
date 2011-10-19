<?php

/**
 *  Carregamento das funcionalidades básicas do EasyFramework.
 *
 *  @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 *  @copyright Copyright 2011, EasyFramework (http://www.easy.lellysinformatica.com)
 *
 */
/* Inclui as classes baicas */
require_once "common/basics.php";
/* Inclui as classes de funcionamento */
App::import("Core", array(
    "common/class_registry",
    "common/filesystem",
    "common/hookable",
    "common/validation",
    "common/inflector",
    "controller/controller",
    "debug/debug",
    "dispatcher/dispatcher",
    "dispatcher/mapper",
    "model/model",
    "security/security",
    "storage/cookie",
    "storage/session",
    "view/view"
));
/* Inclui a biblioteca smarty */
App::import("Lib", "smarty/Smarty.class");
/* Inclui as configurações da app */
App::import('Config', array('functions', 'database', 'settings'));
/*  Inclusão das classes da biblioteca do EasyFramework ou das classes as sobrescrevem */
App::import("Controller", "app_controller");
App::import("Model", "app_model");
?>