<?php
require_once 'src/RankManager.php';
require_once 'src/UserManager.php';

$config      = require 'config.php';
$rankManager = new RankManager($config);
$userManager = new UserManager($config, $rankManager);

$top3     = $userManager->getTop3();
$top10    = $userManager->getTop10();
$rankings = $userManager->getRankings();

require 'templates/layout.php';
