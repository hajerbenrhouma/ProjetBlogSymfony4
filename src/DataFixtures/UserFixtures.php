<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$name, $last_name, $email, $password, $api_Key, $roles]) {
            $user = new User();
            $user->setName($name);
            $user->setRoles($roles);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setVimeoApiKey($api_Key);
            $this->addReference('user_Admin', $user);
            $manager->persist($user);

        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['user_Admin', 'user_Admin', 'brh@gmail.com','passw', 'passw', ['ROLE_ADMIN']],
            ['AHMED', 'Ben SALEG', 'AHMED@gmail.com','passw123', 'passw123', ['ROLE_USER']]
        ];
    }
}
