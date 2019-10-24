<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Customer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        /** @var User $users */
        $users = $manager->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            /** @var Company $companies */
            $companies = $manager->getRepository(Company::class)->findBy(['user' => $user]);

            foreach ($companies as $company) {
                /** @var Customer $customer */
                $customer = new Customer();

                $customer->setFirstName($faker->firstName)
                         ->setLastName($faker->lastName)
                         ->setEmail($faker->email)
                         ->setUser($user)
                         ->setCompany($company);

                $manager->persist($customer);
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
            CompanyFixtures::class,
        ];
    }
}
