<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class User extends Entity
{
    protected array $_accessible = [
        'name' => true,
        'email' => true,
        'password' => true,
        'role_id' => true,
        'created' => true,
        'modified' => true,
    ];

    protected array $_hidden = ['password'];

    protected function _setPassword(string $password): ?string
    {
        if ($password === '') {
            return null;
        }
        return (new DefaultPasswordHasher())->hash($password);
    }
}
