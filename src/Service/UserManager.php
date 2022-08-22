<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserManager
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(): array
    {
        return $this->userRepository->findAll();
    }
}