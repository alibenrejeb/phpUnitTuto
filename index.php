<?php
require_once __DIR__ . '/vendor/autoload.php';

$advertService = new \App\Service\AdvertService();

$result = $advertService->getAllAdvert();
echo "<pre>";
print_r($result);
die;