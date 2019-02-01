<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10,Tag::class, function(int $i) {
            $tag = new Tag();
            $tag->setName($this->faker->realText(20));

            return $tag;
        });
        $manager->flush();
    }
}
