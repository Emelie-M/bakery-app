<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use Monolog\Handler\Handler;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(private ResponseFactoryInterface $responseFactory) {}

    /**
     * Process the request - check if user is authenticated.
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // TODO: Read 'is_authenticated' from the session.
        //       If the user is not authenticated, add an error flash message and redirect to the login page.
        //       If the user is authenticated, pass the request on with $handler->handle($request).
        //
        //       Use the following to generate the login URL and create a redirect response:
        //       $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        //       $loginUrl = $routeParser->urlFor('auth.login');
        //       $response = $this->responseFactory->createResponse(302);
        //       return $response->withHeader('Location', $loginUrl);
        $isAuthenticated = $_SESSION['is_authenticated'];
        if ($isAuthenticated == false) {
            FlashMessage::error('Authentication failed!');
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $loginUrl = $routeParser->urlFor('auth.login');
            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $loginUrl);
        } else {
            return $handler->handle($request);
        }
    }
}
