<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
Use Faker\Factory as  Faker;
class AlbumFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        for ($i=0 ;$i<20 ; $i++){
            $album = new Album ();
            $album->setTitle(implode(' ', $faker->words(3)));
            $album->setReleaseDate($faker->dateTimeBetween('-3 year', 'now'));
            $album->setArtist($faker->name());
            $this->addReference("album_".$i, $album);
            $manager->persist($album);

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

}
