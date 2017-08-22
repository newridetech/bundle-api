<?php

namespace Absolvent\api\tests\Unit\Auth;

use Absolvent\api\app\Auth\JwtUser;
use Absolvent\api\tests\CreatesApplication;
use Codecasts\Auth\JWT\Token\Manager;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

final class JwtAuthenticationGuardTest extends TestCase
{
    use CreatesApplication;

    public function testGuard()
    {
        /** @var Manager $tokenManager */
        $tokenManager = $this->app->make(Manager::class);
        /** @var Request $request */
        $request = $this->app->make('request');
        $request->headers->set('Authorization', 'Bearer ' . $tokenManager->issue(new User(), [
            'acl' => ['a', 'b', 'c'],
        ]));
        /** @var JwtUser $user */
        $user = Auth::authenticate();
        self::assertNotNull($user);
        self::assertTrue($user instanceof JwtUser);
        self::assertSame(['a', 'b', 'c'], $user->getPermissions());
        self::assertTrue($user->can(['a']));
        self::assertTrue($user->can(['a', 'x']));
        self::assertFalse($user->can(['x']));
        self::assertFalse($user->can(['a', 'x'], true));
    }
}
