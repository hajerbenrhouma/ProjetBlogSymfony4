<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user= $this->getReference('user_Admin');
        $comment = new Comment();
        $comment->setAuthor($user);
        $comment->setContent('first comment');
        $comment->setPublished( new \DateTime('2019-15-08 20:00:00'));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($user);
        $comment->setContent('second comment');
        $comment->setPublished( new \DateTime('2019-14-08 06:00:00'));
        $manager->persist($comment);

        $manager->flush();
    }
}
