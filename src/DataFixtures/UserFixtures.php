<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2019-04-02
 * Time: 20:33
 */

namespace App\DataFixtures;


use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $admin = new Users(
            'admin',
            'admin',
            'artuh96@gmail.com'
        );

        $manager->persist($admin);
        $manager->flush();
    }
}