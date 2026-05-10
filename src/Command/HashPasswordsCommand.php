<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:hash-passwords',
    description: 'Hashe les mots de passe en clair dans la base de données.',
)]
class HashPasswordsCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $users = $this->userRepository->findAll();
        $count = 0;

        foreach ($users as $user) {
            $currentPassword = $user->getPassword();

            // Si le mot de passe ne commence pas par un "$" (donc ce n'est pas un hash Bcrypt/Argon)
            if (!str_starts_with($currentPassword, '$')) {
                // On utilise ton Hasher officiel
                $hashedPassword = $this->passwordHasher->hashPassword($user, $currentPassword);
                $user->setPassword($hashedPassword);
                $count++;
            }
        }

        // On sauvegarde le tout dans la base de données
        $this->entityManager->flush();

        $io->success(sprintf('%d mots de passe ont été hashés avec succès !', $count));

        return Command::SUCCESS;
    }
}