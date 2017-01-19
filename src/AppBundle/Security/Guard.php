<?php

namespace AppBundle\Security;

use Fury473\Bundle\AtarashiiBundle\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class Guard extends AbstractGuardAuthenticator
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Called on every request. Return whatever credentials you want,
     * or null to stop authentication.
     */
    public function getCredentials(Request $request)
    {
        if (!$request->getUser() || !$request->getPassword()) {
            return null;
        }

        // What you return here will be passed to getUser() as $credentials
        return array(
            'username' => $request->getUser(),
            'password' => $request->getPassword()
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // if null, authentication will fail
        // if a User object, checkCredentials() is called
        return new User($credentials['username'], $credentials['password'], ['ROLE_USER']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $validation = $this->userService->verifyCredentials();
        if ($validation !== true) {
            throw new CustomUserMessageAuthenticationException($validation);
        }

        // return true to cause authentication success
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return $this->createResponse($request, $exception);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return $this->createResponse($request, $authException);
    }

    public function supportsRememberMe()
    {
        return false;
    }

    private function createResponse(Request $request, AuthenticationException $authException)
    {
        $response = new JsonResponse(strtr($authException->getMessageKey(), $authException->getMessageData()));
        $response->headers->set('WWW-Authenticate', sprintf('Basic realm="%s"', $request->getHost()));
        $response->setStatusCode(Response::HTTP_UNAUTHORIZED);

        return $response;
    }
}
