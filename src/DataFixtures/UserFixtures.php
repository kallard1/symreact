<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * Description $encoder field
     *
     * @var UserPasswordEncoderInterface $encoder
     */
    private $encoder;

    /**
     * Description $logger field
     *
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * UserFixtures constructor
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param LoggerInterface              $logger
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder,
        LoggerInterface $logger
    ) {
        $this->encoder = $encoder;
        $this->logger  = $logger;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < mt_rand(5, 15); $i++) {
            /** @var User $user */
            $user = new User();

            /** @var string $email */
            $email = $faker->email;
            /** @var string $password */
            $password = $faker->password(mt_rand(8, 20));
            $hashedPassword = $this->encoder->encodePassword($user, $password);

            $user->setEmail($email)
                 ->setPassword($hashedPassword)
                 ->setFirstName($faker->firstName)
                 ->setLastName($faker->lastName);

            $manager->persist($user);
            $this->logger->info("User $i: $email / $password");
        }

        $manager->flush();
    }
}
