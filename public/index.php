<?php
declare(strict_types=1);

$app = require_once __DIR__ . '/../Bootstrap/App.php';

require_once __DIR__ . '/../routes/web.php';

$app->run();
