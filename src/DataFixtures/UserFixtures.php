<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
Use Faker\Factory  as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface) {

    }
    public function load(ObjectManager $manager): void
    {
        //création des fixtures
        $roles = [
            'ROLE_ADMIN',
            'ROLE_USER',
            'ROLE_ARTIST'
        ] ;
        $faker = Faker::create('fr_FR');
        for ($i=0 ;$i<20 ; $i++){
            $user = new User();
            if ($i<2) {
                $user->setRoles([$roles[0]]);
            } 
            elseif ($i<4) {
                $user->setRoles([$roles[2]]);

            }
            else {
                $user->setRoles([$roles[1]]);
            }
            $user->setEmail( $faker->unique()->email());
            $user->setUsername( $faker->unique()->username);
            $hashedPassword = $this->userPasswordHasherInterface->hashPassword($user, "password");
            $user->setPassword( $hashedPassword );
            $manager->persist($user);
            $this->addReference("user_".$i, $user);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
