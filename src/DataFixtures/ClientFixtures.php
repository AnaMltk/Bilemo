<?php

namespace App\DataFixtures;

use App\Entity\Client;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ClientFixtures extends Fixture
{
    public $encoder;
    public const ORANGE = 'Orange';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
            $client = new Client();
            $client->setName('Orange');
            $client->setEmail('admin@orange.com');
            $password = $this->encoder->encodePassword($client, 'admin');
            $client->setPassword($password);
            $this->addReference(self::ORANGE, $client);
            $manager->persist($client);

        $manager->flush();
    }
}
