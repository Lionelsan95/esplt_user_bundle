<?php

namespace App\Controller;

use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'esplt_user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/list', name: 'list')]
    public function list(UserManager $manager)
    {
        $this->denyAccessUnlessGranted('list');

        $users = $manager->list();
    }
}
