<?php
// Keeps this folder in the package: the 1.7.2 SDK autoloader resolves classes through vendor/composer/../../src,
// so the folder must exist for ../../src/Requests/API.php (the upgrade shim) to be found. Silence is golden.
