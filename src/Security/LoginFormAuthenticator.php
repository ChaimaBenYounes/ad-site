<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Routing\RouterInterface;

use App\Repository\UserRepository;


class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $userRepository;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct( 
        UserRepository $userRepository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder){

        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        //dd($request);
        // dd($request->request->all()) <=> dd($_POST)
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']

        );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // Verifying the CSRF Token  `CsrfTokenManagerInterface`
        // getToken($tokenId), refreshToken($tokenId), removeToken($tokenId), isTokenValid(CsrfToken $token) ...
        // CsrfToken(id, value)
        // The `id` is referring to that string - authenticate
        // The `value` is the CSRF token value that the user submitted = $credentials['csrf_token']
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if(!$this->csrfTokenManager->isTokenValid($token)){
            throw new InvalidCsrfTokenException();
        }
        
        // dd($credentials) recupere les valeurs du getCredentials
        return $this->userRepository->findOneBy(['email'=> $credentials['email']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        //dd($user);
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // if checkCredentials() return true 
        //$providerKey = the name of firewall  
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            // If it's not empty $targetPath, if there is something stored in the session
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('home'));

    }

    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }


}
