<?php

namespace App\Controller;

use App\Service\UserManager;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

use OpenApi\Attributes as OA;

#[Route('/api/user', name: 'esplt_user_')]
class UserController extends AbstractController
{

    private Serializer $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/list', name: 'list')]
    #[Security(name: 'Bearer')]
    public function list(UserManager $manager): JsonResponse
    {
        $this->denyAccessUnlessGranted('list');

        $users = $manager->list();

        $data = $this->serializer->normalize($users, null, ['groups' => 'list']);

        return new JsonResponse($data, 200);
    }
}
