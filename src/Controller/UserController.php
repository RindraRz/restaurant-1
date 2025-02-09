<?php namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api', name: 'api_')]
class UserController
{
    #[Route('/register', name: 'user_register', methods: ['POST'])]
    
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Vérifier si les champs nécessaires existent
        if (!isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(['error' => 'Missing email or password'], 400);
        }

        $user = new User();
        $user->setEmail($data['email']);

        // Hacher le mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Définir les rôles (optionnel)
        $user->setRoles(['ROLE_USER']);

        // Sauvegarder en base de données
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User created successfully'], 201);
    }
}
