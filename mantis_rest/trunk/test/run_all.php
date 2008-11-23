<?php
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'mantis_rest_core.php';

require_once 'test/alltests.class.php';

$result = PHPUnit_TextUI_TestRunner::run(AllTests::suite());
