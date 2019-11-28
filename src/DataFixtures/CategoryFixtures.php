<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadMainConfiguration($manager);
        $this->loadSubCategories($manager, 'Electronics', 1);
        $this->loadComputers($manager);
        $this->loadLaptops($manager);
        $this->loadBooks($manager);
    }


    public function loadMainConfiguration($manager)
    {
        foreach ($this->getMainGategoriesData() as [$name]) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        $manager->flush();
    }

    public function getMainGategoriesData()
    {
        return [
            ['Electronics', 1],
            ['Toys', 2],
            ['Books', 3],
            ['Movies', 4],];
    }

    private function loadSubCategories($manager, $category, $parent_id)
    {
        $parent = $manager->getRepository(Category::class)
            ->find($parent_id);
        $methodeName = "get{$category}Data";
        foreach ($this->$methodeName() as [$name]) {

            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);
        }
        $manager->flush();
    }


    private function getElectronicsData()
    {
        return [
            ['Camera', 5],
            ['Computer', 6],
            ['Cell Phones', 7]];
    }

    private function getComputersData()
    {
        return [
            ['Laptop', 8],
            ['Desktop', 9],];
    }

    public function loadComputers($manager)
    {
        $this->loadSubCategories($manager, 'Computers', 6);
    }

    private function getLaptopData()
    {
        return [
            ['Hp', 10],
            ['Lenovo', 11],];
    }

    public function loadLaptops($manager)
    {
        $this->loadSubCategories($manager, 'Laptop', 8);
    }

    private function getBooksData()
    {
        return [
            ['Romance', 12],
            ['Drama', 13],];
    }

    public function loadBooks($manager)
    {
        $this->loadSubCategories($manager, 'Books', 3);
    }
}
