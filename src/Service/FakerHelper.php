<?php
namespace App\Service;

use Faker\Factory;
use Liior\Faker\Prices;
use Bezhanov\Faker\Provider\Device;

class FakerHelper
{
    public static function addFaker(){
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Device($faker));
        
        $faker->deviceBuildNumber; // 186
        $faker->deviceManufacturer; // Apple
        $faker->deviceModelName; // iPhone 4
        $faker->devicePlatform; // Ubuntu Touch
        $faker->deviceSerialNumber; // ejfjnRNInxh0363JC2WM
        $faker->deviceVersion; // 812
        
        return $faker;
    }

}