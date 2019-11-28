<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VideoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ( $this->VideoData()  as [$title, $path, $category_id]){
            $duration = random_int(10,  300);
            $category = $manager->getRepository(Category::class) ->find($category_id);
            $video = new Video();
            $video ->setTitle($title);
            $video ->setPath('https://player.vimeo.com/video/'. $path);
            $video ->setCategory($category);
            $video ->setDuration($duration);
            $manager ->persist($video);
        }

        $manager->flush();
    }

    private function VideoData(){
        return [
            ['Movies 1', 25876945,4],
            ['Movies 2', 25876876985,4],
            ['Movies 3', 2587458945,4],
            ['Movies 4', 238902809,4],
            ['Movies 5', 258769235,4],
            ['Movies 6', 150870038,4],
            ['Movies 7', 258798945,4],
            ['Movies 8', 289879647,4],

            ['Romantic comedy 1', 261379936, 19],
            ['Romantic comedy 2', 98745896, 19],

            ['Romantic drama 1', 289029793, 20],

            ['Toys 1', 60594348, 2],
            ['Toys 2', 290253648, 2],
            ['Toys 3', 289729765, 2],
            ['Toys 4', 98745896, 2],
        ];
    }
}
