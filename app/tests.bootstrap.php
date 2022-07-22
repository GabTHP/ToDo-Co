<?php
// delete database if exists, then create
passthru('php bin/console doctrine:database:drop --env=test --force --if-exists');
passthru('php bin/console doctrine:database:create --env=test');
passthru('php bin/console doctrine:schema:update --env=test --force');


// run migrations
