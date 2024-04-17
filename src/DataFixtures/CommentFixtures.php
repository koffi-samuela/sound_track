<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as  Faker;
class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        for($i=0 ;$i<15 ; $i++){
            $comment = new Comment();
            $comment->setContent($faker->paragraph(3));
            $comment->setCreatedAt($faker->dateTimeBetween('-2 year', 'now'));
            $comment->setAlbum($this->getReference("album_".$faker->numberBetween(0,19)));
            $comment->setUser($this->getReference("user_".$faker->numberBetween(0,19)));
            $manager->persist($comment);
        }
            
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AlbumFixtures::class

        ];
    }
}
