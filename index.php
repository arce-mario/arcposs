<?php

//Controllers
require_once "controllers/Template.controller.php";
require_once "controllers/Dashboard.controller.php";
require_once "controllers/User.controller.php";
require_once "controllers/Client.controller.php";
require_once "controllers/Category.controller.php";
require_once "controllers/Product.controller.php";
require_once "controllers/Report.controller.php";
require_once "controllers/Sale.controller.php";

//Models
require_once "models/Dashboard.model.php";
require_once "models/User.model.php";
require_once "models/Client.model.php";
require_once "models/Category.model.php";
require_once "models/Product.model.php";
require_once "models/Report.model.php";
require_once "models/Sale.model.php";

require_once "resources/Notifications.php";
require_once "resources/Image.user.php";

//Start template of all views
$template = new TemplateController();
$template -> getTemplate();