<?php

namespace App\DataFixtures;

use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as  Faker;
class SongFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        for ( $i=0 ; $i <100 ;$i++ ) {
            $song = new Song ();
            $song->setTitle($faker->words(2, true));
            $song->setDuration(rand(60 ,300));
            $song->setAlbum($this->getReference("album_".$faker->numberBetween(0,19)));
            $manager->persist ($song);          
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
