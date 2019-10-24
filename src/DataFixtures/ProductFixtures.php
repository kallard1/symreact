<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
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

        foreach ($users as $user) {
            /** @var Category $categories */
            $categories = $manager->getRepository(Category::class)->findBy(['user' => $user]);

            foreach ($categories as $category) {
                for ($i = 1; $i < mt_rand(self::MIN, self::MAX); $i++) {
                    /** @var Product $product */
                    $product = new Product();

                    $product->setName($faker->sentence(2))
                            ->setDescription($faker->paragraph(3))
                            ->setPrice($faker->randomFloat(2, 50))
                            ->setUser($user)
                            ->addCategory($category);

                    $manager->persist($product);
                }
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
            CategoryFixtures::class,
        ];
    }
}
