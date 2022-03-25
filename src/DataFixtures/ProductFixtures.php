<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use App\Service\FakerHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProductFixtures extends Fixture
{
    private $helper;

    public function __construct(FakerHelper $helper)
    {
        $this->helper = $helper;
    }
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $product = new Product();
            $faker = $this->helper->addFaker();
            $product->setName($faker->deviceModelName());
            $product->setDescription('Phone '.$faker->deviceModelName());
            $product->setCategory('phones');
            $product->setStatus(1);
            $product->setPrice(rand(100, 1000));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
