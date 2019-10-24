<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var int MIN */
    private const MIN = 1;
    /** @var int MAX */
    private const MAX = 25;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        /** @var User $users */
        $users = $manager->getRepository(User::class)->findAll();

        foreach($users as $user) {
            for ($i = 1; $i < mt_rand(self::MIN, self::MAX); $i++) {
                /** @var Category $category */
                $category = new Category();

                $category->setLabel($faker->sentence(1))
                         ->setEnabled(mt_rand(0, 1))
                         ->setUser($user);

                $manager->persist($category);
            }
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
