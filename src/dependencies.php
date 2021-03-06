<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    $view = new Slim\Views\Twig($settings['template_path'], $settings['twig']);
    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Setup Cache
use phpFastCache\CacheManager;
use App\Utils\Repo;
use App\Utils\Database;

CacheManager::setDefaultConfig($container->get('settings')['cache']);
Repo::setCache(CacheManager::getInstance('files')); // !!! Extremely Important !!!
// TODO : Change Repo to Singleton to avoid above line

Database::setup();

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container[App\Page\SigninPage::class] = function($c) {
    return new App\Page\SigninPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\AdminPage::class] = function($c) {
    return new App\Page\AdminPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\HomePage::class] = function($c) {
    return new App\Page\HomePage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\AnnouncementsPage::class] = function($c) {
    return new App\Page\AnnouncementsPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\ContributionsPage::class] = function($c) {
    return new App\Page\ContributionsPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\ProjectsPage::class] = function($c) {
    return new App\Page\ProjectsPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\ProjectPage::class] = function($c) {
    return new App\Page\ProjectPage($c->get('renderer'), $c->get('logger'));
};


$container[App\Page\DownloadsPage::class] = function($c) {
    return new App\Page\DownloadsPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\TeamPage::class] = function($c) {
    return new App\Page\TeamPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\RoboconPage::class] = function($c) {
    return new App\Page\RoboconPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\DevelopersPage::class] = function($c) {
    return new App\Page\DevelopersPage($c->get('renderer'), $c->get('logger'));
};

$container[App\CacheControl::class] = function () {
    return new App\CacheControl();
};

$container[App\ImageServer::class] = function() {
    return new App\ImageServer();
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c->renderer->render($response, '404.twig', ['base_url' => $uri = $request->getUri()->getBasePath()]);
    };
};