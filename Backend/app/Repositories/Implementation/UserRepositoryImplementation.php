<?php

namespace App\Repositories\Implementation;

use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;

/**
 * Implementação do Repository de User.
 */
class UserRepositoryImplementation extends BaseRepositoryImplementation implements UserRepositoryInterface {
    
    public function __construct() {
        parent::__construct(User::class);
    }
    
    public function findByUsername(string $username): ?array {
        return $this->findBy('username', $username);
    }
}
