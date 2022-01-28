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
            $product->setDescription('This is a phone');
            $product->setCategory('phones');
            $product->setStatus(1);
            $product->setPrice(500);
            $manager->persist($product);
        }
        $product1 = new Product();
        $product1->setName('Iphone 11');
        $product1->setDescription('This is an Iphone');
        $product1->setPrice(500);
        $product1->setCategory('phones');
        $product1->setStatus(1);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Samsung Galaxy');
        $product2->setDescription('This is an Samsung');
        $product2->setPrice(500);
        $product2->setCategory('phones');
        $product2->setStatus(1);
        $manager->persist($product2);

        $manager->flush();
    }
}
