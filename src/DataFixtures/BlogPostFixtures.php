<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\BlogPost;
class BlogPostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user= $this->getReference('user_Admin');

        $blogPost = new BlogPost();
        $blogPost->setTitle('A first post');
        $blogPost->setPublished(new \DateTime('2018-07-01 12:00:00'));
        $blogPost->setContent('Set Post');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a first post');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('A second post');
        $blogPost->setPublished(new \DateTime('2018-07-07 07:00:00'));
        $blogPost->setContent('Set second Post');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a second post');
        $manager->persist($blogPost);

        $manager->flush();
    }
}
