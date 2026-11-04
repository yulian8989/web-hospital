<?php

namespace App\Services;

use App\Repositories\AuthRepository; // Sesuaikan dengan namespace AuthRepository Anda
use Illuminate\Http\UploadedFile;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        return $this->authRepository->register($data);
    }

    public function login(array $data)
    {
        return $this->authRepository->login($data);
    }

    public function tokenLogin(array $data)
    {
        return $this->authRepository->tokenLogin($data);
    }

    private function uploadPhoto(UploadedFile $photo)
    {
        return $photo->store('users', 'public');
    }
}