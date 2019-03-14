<?php

namespace  App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ProductType;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.product.index")
     * @param ProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProductRepository $repop, CategoryRepository $repoc) : Response
    {
        // je reccuper tous les produits dans ma bdd et je les mets dans une variable products
        $products = $repop->findAll();
        $categories = $repoc->findAll();

        // je génere ma vue
        return $this->render('admin/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
    /**
     * @Route("/admin/product/create", name="admin.product.new")
     */
    public function new(Request $request, ObjectManager $pm)
    {
        $product = new Product();
        // on crée un formulaire
        $form = $this -> createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()){
            //on demande au formulaire de persister les information
            $pm->persist($product);
            $pm->flush();
            $this->addFlash('success','Produit ajouté à votre liste des produits avec succés');
            return $this->redirectToRoute('admin.product.index');
        }
        return $this->render('admin/new.html.twig', [
            'product' => $product ,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/category/create", name="admin.category.new")
     */
    public function newcat (Request $request, ObjectManager $cm)
    {
        $category = new Category();
        // on crée un formulaire
        $form = $this -> createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()){
            //on demande au formulaire de persister les information
            $cm->persist($category);
            $cm->flush();
            $this->addFlash('success','Categorie ajouté à votre liste des categories avec succés');
            return $this->redirectToRoute('admin.product.index');
        }
        return $this->render('admin/new.html.twig', [
            'category' => $category ,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/product/{id}", name="admin.product.edit", methods="GET|POST")
     * @param  Product $product
     * @param Request $request
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public  function  edit (Product $product, Request $request, ObjectManager $pm)
    {
        $form = $this->createForm(ProductType::class, $product);
        // on demande à notre formulaire de gérer la requette
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()){
            $pm->flush();
            $this->addFlash('success','Produit modifié avec succés');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/edit.html.twig', [
            'product' => $product,
            'form' => $form ->createView()
        ]);
    }
    /**
     * @Route("/admin/category/{id}", name="admin.category.edit", methods="GET|POST")
     * @param  Category $category
     * @param Request $request
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public  function  editcat (Category $category, Request $request, ObjectManager $cm)
    {
        $form = $this->createForm(CategoryType::class, $category);
        // on demande à notre formulaire de gérer la requette
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()){
            $cm->flush();
            $this->addFlash('success','Catégorie modifié avec succés');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/product/{id}", name="admin.product.delete", methods="DELETE")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function  delete(Product $product, Request $request, ObjectManager $pm)
    {
        if($this->isCsrfTokenValid('delete'.$product->getId(),$request->get('_token')))
        {
            $pm->remove($product);
            $pm->flush();
            $this->addFlash('success','Produit supprimé avec succés');

        }
        return $this->redirectToRoute('admin.product.index');
    }
    /**
     * @Route("/admin/category/{id}", name="admin.category.delete", methods="DELETE")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function  deletecat(Category $category, Request $request, ObjectManager $pm)
    {
        if($this->isCsrfTokenValid('delete'.$category->getId(),$request->get('_token')))
        {
            $pm->remove($category);
            $pm->flush();
            $this->addFlash('success','Catégorie supprimé avec succés');

        }
        return $this->redirectToRoute('admin.product.index');
    }

}