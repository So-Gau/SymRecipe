<?php

namespace App\Controller;

use App\Entity\Ingredien;
use App\Form\IngredientType;
use App\Repository\IngredienRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ingredient', methods: ['GET'])]
class IngredientController extends AbstractController
{
    #[Route('/', name: 'ingredient.index', methods: ['GET'])]
    public function index(IngredienRepository $repository,PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    #[Route('/nouveau', 'ingredient.new', methods:['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ): Response 
    {
        $ingredient = new Ingredien();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();
            $manager->persist($ingredient); //consigne de l'envoyer
            $manager->flush(); // exécute le code 

            return $this->redirectToRoute('ingredient.index');
        }

        return $this->render('ingredient/new.html.twig' , [
            'form' => $form->createView()
        ]);
    }
}
