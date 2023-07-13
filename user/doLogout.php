<?php
require_once("../utilities/alertFunc.php");
session_start();
session_destroy();

alertAndGoToList("您已登出系統");
