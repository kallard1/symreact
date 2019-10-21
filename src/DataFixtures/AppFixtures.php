<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        /** @var $faker */
        $faker = Factory::create('fr_FR');

        for ($u = 0; $u < 50; $u++) {
            /** @var int $chrono */
            $chrono = 1;
            /** @var User $user */
            $user = new User();
            /** @var string $password */
            $password = $this->encoder->encodePassword($user, "password");

            $user->setFirstName($faker->firstName)
                 ->setLastName($faker->lastName)
                 ->setEmail($faker->email)
                 ->setPassword($password);

            $manager->persist($user);

            for ($c = 0; $c < mt_rand(1, 10); $c++) {
                /** @var Customer $customer */
                $customer = new Customer();

                $customer->setFirstName($faker->firstName)
                         ->setLastName($faker->lastName)
                         ->setCompany($faker->company)
                         ->setEmail($faker->email)
                         ->setUser($user);

                $manager->persist($customer);

                for ($i = 0; $i < mt_rand(1, 10); $i++) {
                    /** @var Invoice $invoice */
                    $invoice = new Invoice();

                    $invoice->setAmount($faker->randomFloat(2, 50, 1500))
                            ->setSentAt($faker->dateTimeBetween('-12 months'))
                            ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELED']))
                            ->setCustomer($customer)
                            ->setChrono($chrono);

                    $chrono++;

                    $manager->persist($invoice);
                }
            }
        }

        $manager->flush();
    }
}
