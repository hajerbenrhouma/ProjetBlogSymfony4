<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Utils\CategoryTreeAdminList;
use App\Utils\CategoryTreeAdminOptionList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_main_page")
     */
    public function index()
    {
        return $this->render('admin/my_profile.html.twig');
    }

    /**
     * @Route("/su/categories", name="categories", methods={"GET", "POST"})
     */
    public function categories(CategoryTreeAdminList $categories, Request $request)
    {
        $categories->getCategoryList($categories->buildTree());

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $is_invalid = null;
        if ($this->saveCategory($category, $form, $request)) {

            return $this->redirectToRoute('categories');
        } elseif ($request->isMethod('post')) {
            $is_invalid = ' is-invalid';
        }

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories->categorylist,
            'form' => $form->createView(),
            'is_invalid' => $is_invalid
        ]);
    }

    /**
     * @Route("/videos", name="videos")
     */
    public function videos()
    {
        return $this->render('admin/videos.html.twig');
    }

    /**
     * @Route("/su/uploadvideo", name="uploadvideo")
     */
    public function uploadvideo()
    {
        return $this->render('admin/upload_video.html.twig');
    }

    /**
     * @Route("/su/users", name="users")
     */
    public function users()
    {
        return $this->render('admin/users.html.twig');
    }

    /**
     * @Route("/su/edit_category/{id}", name="edit_category", methods={"GET", "POST"})
     */
    public function edit_category(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $is_invalid = null;
        if ($this->saveCategory($category, $form, $request))
        {
          return $this->redirectToRoute('categories');
        }
        elseif ($request->isMethod('post'))
        {
            $is_invalid = ' is-invalid';
        }


        return $this->render('admin/edit_category.html.twig',
            ['category' => $category,
                'form' => $form ->createView(),
                'is_invalid' => $is_invalid]);
    }

    /**
     * @Route("/su/delete_category/{id}", name="delete_category")
     */
    public function delete_category(Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirectToRoute("categories");
    }

    public function getAllCategories(CategoryTreeAdminOptionList $categories, $editedCategory = null)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $categories->getCategoryList($categories->buildTree());
        return $this->render('admin/_all_categories.html.twig', [
            'categories' => $categories,
            'editedCategory' => $editedCategory
        ]);
    }

    // function to appear list of categories that exist in database in the end of categories page

    private function saveCategory($category, $form, $request)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->setName($request->request->get('category')['name']);
            $repository = $this->getDoctrine()->getRepository(Category::class);
            $parent = $repository->find($request->request->get('category')['parent']);
            $category->setParent($parent);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            return true;
        } else return false;
    }

}
