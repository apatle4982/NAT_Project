<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

return static function (RouteBuilder $routes) {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/', ['controller' => 'Users', 'action' => 'index']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        
         // router for publioc notes url
        $builder->connect(
            '/{controller}/{action}/{fmd}/{doctype}' ,
            ['controller' => 'PublicNotes']
        )->setPatterns([
            'fmd' => '[0-9]+',
            'doctype' => '[0-9]+' 
        ]);

        $builder->connect(
            '/{controller}/{action}/{fmd}/{doctype}/{section}' ,
            ['controller' => 'PublicNotes', 'action'=>'index']
        )->setPatterns([
            'fmd' => '[0-9]+',
            'doctype' => '[0-9]+',
            'section' => '[a-z0-9-_]+'
        ]);

        // router for edit 
        $builder->connect(
            '/{controller}/edit/{fmd}/{doctype}/{pageType}/{section}' ,
            [ 'action'=>'edit']
        )->setPatterns([
            'fmd' => '[0-9]+',
            'doctype' => '[0-9]+',
            'pageType' => '[a-z0-9-_]+',
            'section' => '[a-z0-9-_]+'
        ]);
        // router for complete edit 
        $builder->connect(
            '/{controller}/edit/{fmd}/{doctype}/{section}' ,
            [ 'action'=>'edit']
        )->setPatterns([
            'fmd' => '[0-9]+',
            'doctype' => '[0-9]+',
            'section' => '[a-z0-9-_]+'
        ]);
         $builder->connect(
            '/{controller}/{action}/{fmd}/{doctype}' ,
            [ 'action'=>'edit']
        )->setPatterns([
            'fmd' => '[0-9]+',
            'doctype' => '[0-9]+' 
        ]);

        // router for user section view
        $builder->connect(
            '/{controller}/{action}/{fmd}/{doctype}' ,
            ['action'=>'view']
        )->setPatterns([
            'fmd' => '[0-9]+',
            'doctype' => '[0-9]+' 
        ]);
  
        // router for masterdata view pdf 
        $builder->connect(
            '/{controller}/viewpdf/{fmd}/{doctype}' ,
            ['controller' => 'MasterData', 'action'=>'viewpdf']
        )->setPatterns([
            'fmd' => '[0-9]+',
            'doctype' => '[0-9]+' 
        ]);


        $builder->fallbacks();
    });

    /**
     * Router For Rest API's
     */
    $routes->prefix('api', function (RouteBuilder $routeBuilder) {
        $routeBuilder->setRouteClass(DashedRoute::class);
        
        $routeBuilder->connect('/create-orders', [
            'controller' => 'NatApi',
            'action' => 'createOrders',
            'method'=>'post'
        ]);

        $routeBuilder->connect('/get_pre_aol/:PartnerFileNumber', ['controller' => 'NatApi', 'action' => 'get_pre_aol'])
            ->setPass(['PartnerFileNumber']) // this tells Cake to pass `:id` as method argument
            ->setMethods(['GET']);

        $routeBuilder->connect('/get_final_aol/:PartnerFileNumber', ['controller' => 'NatApi', 'action' => 'get_final_aol'])
            ->setPass(['PartnerFileNumber']) // this tells Cake to pass `:id` as method argument
            ->setMethods(['GET']);    
    });
    /* 
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
 /*
   // http://localhost/projects/lrs_staging/api/checkclear
    $routes->scope('/api', function (RouteBuilder $builder) {
        $builder->setExtensions(['json']);
        $builder->post('/checkclear', ['controller'=>'AccountHuntington','action'=>'apiCheckClear']);
    }); 
 
    $routes->scope('/api', function (RouteBuilder $builder) {
        $builder->setExtensions(['json']);
        $builder->post('/simplifileAccounting', ['controller'=>'SimplifileAccounting','action'=>'index']);
    }); 
    $routes->scope('/api', function (RouteBuilder $builder) {
        $builder->setExtensions(['json']);
        $builder->post('/cscAccounting', ['controller'=>'CscAccounting','action'=>'index']);
    });  */
};