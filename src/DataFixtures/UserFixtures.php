<?php

namespace App\DataFixtures;

use App\Entity\User;

use App\DataFixtures\ClientFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $user = new User();
            $user->setFirstName('John');
            $user->setLastName('Doe');
            $user->setEmail('johndoe@gmail.com');
            $user->setClient($this->getReference(ClientFixtures::ORANGE));
           
            $manager->persist($user);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ClientFixtures::class
        ];
    }
}
