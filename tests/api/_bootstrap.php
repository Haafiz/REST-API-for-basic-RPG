<?php
(new Dotenv\Dotenv(__DIR__.'/../../'))->load();
putenv('APP_ENV=testing');
$testDB = env(DB_TEST_DATABASE);
putenv("DB_DATABASE=$testDB");