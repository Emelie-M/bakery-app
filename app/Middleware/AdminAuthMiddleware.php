<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

class AdminAuthMiddleware implements MiddlewareInterface
{
    public function __construct(private ResponseFactoryInterface $responseFactory) {}

    /**
     * Process the request - check if user is authenticated AND is an admin.
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // TODO: Read 'is_authenticated' and 'user_role' from the session.
        //       If the user is not authenticated, add an error flash message and redirect to 'auth.login'.
        //       If the user is authenticated but not an admin, add the error flash message
        //       "Access denied." and redirect to 'user.dashboard'.
        //       If both checks pass, pass the request on with $handler->handle($request).
        //
        //       Use the same redirect pattern as AuthMiddleware (RouteParser + responseFactory).
        $isAuthenticated = $_SESSION['is_authenticated'];
        if ($isAuthenticated == false) {
            FlashMessage::error('Authentication failed!');
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $loginUrl = $routeParser->urlFor('auth.login');
            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $loginUrl);
        } else if ($isAuthenticated == true && $_SESSION['user_role'] != 'admin') {
            FlashMessage::error('Access denied!');
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $loginUrl = $routeParser->urlFor('user.dashboard');
            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $loginUrl);
        } else {
            return $handler->handle($request);
        }
    }
}
