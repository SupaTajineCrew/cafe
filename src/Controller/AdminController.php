<?php

namespace  App\Controller;

use App\Form\ProductType;
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
     * @var ProductRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $pm;

    public  function  __construct(ProductRepository $repository, ObjectManager $pm)
    {
        $this->repository = $repository;
        $this->pm = $pm;
    }
    // "pm" est une variable initialiser  de product manager


    /**
     * @Route("/admin", name="admin.product.index")
     * @param ProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProductRepository $repository) : Response
    {
        // je reccuper tous les produits dans ma bdd et je les mets dans une variable products
        $products = $this->repository->findAll();
        // je génere ma vue
        return $this->render('admin/index.html.twig', compact('products'));
    }
    /**
     * @Route("/admin/product/create", name="admin.product.new")
     */
    public function new (Request $request)
    {
        $product = new Product();
        // on crée un formulaire
        $form = $this -> createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()){
            //on demande au formulaire de persister les information
            $this->pm->persist($product);
            $this->pm->flush();
            $this->addFlash('success','Produit ajouté à votre liste des produits avec succés');
            return $this->redirectToRoute('admin.product.index');
        }
        return $this->render('admin/new.html.twig', [
            'product' => $product ,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/product/{id}", name="admin.product.edit", methods="GET|POST")
     * @param  Product $product
     * @param Request $request
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public  function  edit (Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);
        // on demande à notre formulaire de gérer la requette
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()){
            $this ->pm->flush();
            $this->addFlash('success','Produit modifié avec succés');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/edit.html.twig', [
            'product' => $product,
            'form' => $form ->createView()
        ]);
    }

    /**
     * @Route("/admin/product/{id}", name="admin.product.delete", methods="DELETE")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function  delete(Product $product, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$product->getId(),$request->get('_token')))
        {
            $this->pm->remove($product);
            $this->pm->flush();
            $this->addFlash('success','Produit supprimé avec succés');

        }
        return $this->redirectToRoute('admin.product.index');
    }

}