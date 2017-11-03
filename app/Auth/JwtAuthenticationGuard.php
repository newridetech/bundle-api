<?php
/**
 * Created by PhpStorm.
 * User: Michał Kowalik <maf.michal@gmail.com>
 * Date: 20.08.17 21:25
 */

namespace Newride\api\app\Auth;

use Codecasts\Auth\JWT\Token\Manager;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Lcobucci\JWT\Token;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JwtAuthenticationGuard
 *
 * @package Newride\NewrideBackend\app\Auth
 *
 * @author  Michał Kowalik <maf.michal@gmail.com>
 */
class JwtAuthenticationGuard implements Guard
{
    /** @var Token */
    private $token;
    /** @var JwtUser */
    private $user;

    public function __construct(?Token $token)
    {
        $this->token = $token === null || $token->isExpired() ? null : $token;
    }

    public static function getTokenFromRequest(Manager $tokenManager, Request $request): ?Token
    {
        $token = $request->headers->get('Authorization');
        if (!$token) {
            return null;
        }

        if (!starts_with(strtolower($token), 'bearer ')) {
            return null;
        }

        $token = $tokenManager->parseToken(substr($token, strlen('bearer ')));

        if (!$token || !$tokenManager->validToken($token)) {
            return null;
        }

        return $token;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        return $this->token !== null;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return $this->token === null;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user(): ?Authenticatable
    {
        if ($this->check() && $this->user === null) {
            $this->user = new JwtUser($this->token);
        }
        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return null|string
     * @throws \OutOfBoundsException
     */
    public function id(): ?string
    {
        return $this->check() ? $this->user()->getAuthIdentifier() : null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     *
     * @return bool
     * @throws \DomainException
     */
    public function validate(array $credentials = [])
    {
        throw new \DomainException("JwtAuthenticationGuard.validate");
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->check() ? (string) $this->token : null;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return Authenticatable
     *
     * @throws AuthenticationException
     */
    public function authenticate(): Authenticatable
    {
        if (($user = $this->user()) !== null) {
            return $user;
        }
        throw new AuthenticationException();
    }
}
