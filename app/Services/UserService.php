<?php
require_once __DIR__ . '/../repositories/UserRepository.php';

class UserService
{
    private $repository;

    /**
     * @param $repository
     */
    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function verifyAndGetUser($email, $password)
    {
        return $this->repository->verifyAndGetUser($email, $password);
    }

    /**
     * @throws Exception
     */
    public function hashPassword($password): array
    {
        $salt = bin2hex(random_bytes(32));
        $hashPassword = password_hash($password . $salt, PASSWORD_ARGON2I);
        return [$hashPassword, $salt];
    }
}
