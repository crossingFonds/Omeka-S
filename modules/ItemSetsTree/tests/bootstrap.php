<?php

//require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../../../bootstrap.php';

//make sure error reporting is on for testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Install a fresh database.
file_put_contents('php://stdout', "Dropping test database schema...\n");
\Omeka\Test\DbTestCase::dropSchema();
file_put_contents('php://stdout', "Creating test database schema...\n");
\Omeka\Test\DbTestCase::installSchema();

// Login as admin
$application = \Omeka\Test\DbTestCase::getApplication();
$serviceLocator = $application->getServiceManager();
$auth = $serviceLocator->get('Omeka\AuthenticationService');
$adapter = $auth->getAdapter();
$adapter->setIdentity('admin@example.com');
$adapter->setCredential('root');
$auth->authenticate();

// Enable Search module
$moduleManager = $serviceLocator->get('Omeka\ModuleManager');
$module = $moduleManager->getModule('ItemSetsTree');
if ($module->getState() !== \Omeka\Module\Manager::STATE_ACTIVE) {
    $moduleManager->install($module);
}
