<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @return Response
     */

    public function home(): Response
    {
        return $this->render('pages/home.html.twig');
    }


    /**
     * @Route("/aboutus", name="aboutus")
     * @return Response
     */

    public function aboutus(): Response
    {
        return $this->render('pages/aboutus.html.twig');
    }


    /**
     * @Route("/products", name="products")
     * @return Response
     */

    public function products(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();
        return $this->render('pages/products.html.twig', [
            "products" => $products
        ]);
    }


    /**
     * @Route("/events", name="events")
     * @return Response
     */

    public function events(): Response
    {
        return $this->render('pages/events.html.twig');
    }


    /** 
     * @Route("/gallery", name="gallery")
     * @return Response
     */

    public function gallery(): Response
    {
        return $this->render('pages/gallery.html.twig');
    }


    /**
     * @Route("/services", name="services")
     * @return Response
     */

    public function services(): Response
    {
        return $this->render('pages/services.html.twig');
    }

}