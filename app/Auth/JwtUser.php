<?php
/**
 * Created by PhpStorm.
 * User: Michał Kowalik <maf.michal@gmail.com>
 * Date: 20.08.17 21:44
 */

namespace Newride\api\app\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Lcobucci\JWT\Token;

/**
 * Class JwtUser
 *
 * @package Newride\NewrideBackend\app\Auth
 *
 * @author  Michał Kowalik <maf.michal@gmail.com>
 */
class JwtUser implements Authenticatable
{
    /** @var Token */
    private $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'sub';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     * @throws \OutOfBoundsException
     */
    public function getAuthIdentifier()
    {
        return $this->token->getClaim('sub');
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return '';
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return '';
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return '';
    }

    public function getPermissions(): array
    {
        $acl = $this->token->getClaim('acl');
        return is_array($acl) ? $acl : [];
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function can($permission, $requireAll = false)
    {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->can($permName);

                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            foreach ($this->getPermissions() as $perm) {
                if (str_is($permission, $perm)) {
                    return true;
                }
            }
        }
        return false;
    }
}
