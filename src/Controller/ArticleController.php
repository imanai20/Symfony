<?php

namespace App\Controller;

use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/article', name: 'article')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $voitures = $entityManager->getRepository(Voiture::class)->findAll();

        return $this->render('article/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    
    #[Route('/ajouter-au-panier/{id}', name: 'ajouter_au_panier')]
    public function ajouterAuPanier($id, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        
        $voiture = $entityManager->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            throw $this->createNotFoundException("La voiture n'existe pas.");
        }

        
        $panier = $session->get('panier', []);

        
        $panier[$id] = [
            'id' => $voiture->getId(),
            'marque' => $voiture->getMarque(),
            'modele' => $voiture->getModele(),
            'prix' => $voiture->getPrix()
        ];

        
        $session->set('panier', $panier);

        
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier', name: 'panier')]
    public function afficherPanier(SessionInterface $session): Response
    {
        
        $panier = $session->get('panier', []);

        return $this->render('article/panier.html.twig', [
            'panier' => $panier,
        ]);
    }

    
    #[Route('/supprimer-du-panier/{id}', name: 'supprimer_du_panier', methods: ['POST'])]
    public function supprimerDuPanier($id, SessionInterface $session, Request $request): Response
    {
       
        $panier = $session->get('panier', []);

        
        if (isset($panier[$id])) {
            unset($panier[$id]);
        }

        
        $session->set('panier', $panier);

        
        return $this->redirectToRoute('panier');
    }
}
