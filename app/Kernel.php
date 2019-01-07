<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Container\Container as Container;
use \Illuminate\Support\Facades\Facade as Facade;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Kernel
{
    public static function bootstrap()
    {
        // Create a service container
        $container = new Container;
        $container->bind('app', $container);

        // Create a request from server variables, and bind it to the container; optional
        $request = Request::capture();
        $container->instance('Illuminate\Http\Request', $request);

        $container->singleton('app', 'Illuminate\Container\Container');

        /**
        * Set $app as FacadeApplication handler
        */
        Facade::setFacadeApplication($container);

        // $container->withFacades();

        // Using Illuminate/Events/Dispatcher here (not required); any implementation of
        // Illuminate/Contracts/Event/Dispatcher is acceptable
        $events = new Dispatcher($container);
        // Create the router instance
        $router = new Router($events, $container);
        // Load the routes
        require_once 'routes.php';
        // Create the redirect instance
        $redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));
        // Dispatch the request through the router
        try {
            $response = $router->dispatch($request);
            // Send the response back to the browser
            $response->send();
        } catch (NotFoundHttpException $e) {
            return header('Location: /');
        }
    }
}
