<?php
/**
 * Created by PhpStorm.
 * User: hajer
 * Date: 03/08/2019
 * Time: 20:55
 */

namespace App\Utils\AbstractClasses;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


abstract class CategoryTreeAbstract
{
    protected static $dbconnection;
    public $categoriesArrayFromDb;
    public  $categorylist;

    public function __construct(EntityManagerInterface $entityManager,
                                UrlGeneratorInterface $urlGenerator)
    {
        $this->entitymanager = $entityManager;
        $this->urlgenerator = $urlGenerator;
        $this->categoriesArrayFromDb = $this->getCategories();
    }

    public function getCategories(): array
    {
        if (self::$dbconnection) {
            return self::$dbconnection;
        } else {
            $conn = $this->entitymanager->getConnection();
            $sql = "SELECT * FROM categories";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    abstract public function getCategoryList(array $categories_array);

    public function buildTree(int $parent_id = null): array
    {
        $subcategory = [];
        foreach ($this->categoriesArrayFromDb as $category) {
            if ($category['parent_id'] == $parent_id) {
                $children = $this->buildTree($category['id']);
                if ($children) {
                    $category ['children'] = $children;
                }
                $subcategory[] = $category;
            }
        }
        return $subcategory;
    }
}