<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
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
            for ($i = 1; $i < mt_rand(self::MIN, self::MAX); $i++) {
                /** @var Company $company */
                $company = new Company();

                $company->setName($faker->company)
                        ->setUser($user);

                $manager->persist($company);
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
