<?php
require_once 'src/RankManager.php';
require_once 'src/UserManager.php';

$config      = require 'config.php';
$rankManager = new RankManager($config);
$userManager = new UserManager($config, $rankManager);

$topHead  = $userManager->gettopHead();
$topVIP   = $userManager->gettopVIP();
$rankings = $userManager->getRankings();

if($config['newPrevious']) {
    $userManager->showNewPrevious();
}

require 'templates/layout.php';
