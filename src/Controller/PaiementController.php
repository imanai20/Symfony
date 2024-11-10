<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Paiement;

class PaiementController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function panier(SessionInterface $session): Response
    {
        
        $panier = $session->get('panier', []);

        return $this->render('paiement/panier.html.twig', [
            'panier' => $panier
        ]);
    }

    #[Route('/paiement', name: 'paiement')]
    public function paiement(SessionInterface $session): Response
    {
        
        $panier = $session->get('panier', []);
        $total = array_reduce($panier, fn($sum, $voiture) => $sum + $voiture['prix'], 0);

        return $this->render('paiement/paiement.html.twig', [
            'panier' => $panier,
            'total' => $total,
        ]);
    }

    #[Route('/valider-paiement', name: 'valider_paiement', methods: ['POST'])]
    public function validerPaiement(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
       
        $nom = $request->request->get('nom');
        $email = $request->request->get('email');
        $montant = $request->request->get('montant');
        $methode_paiement = $request->request->get('methode_paiement');
        $numero_carte_bleu = $request->request->get('numero_carte_bleu'); 
    
        
        $paiement = new Paiement();
        $paiement->setNom($nom);
        $paiement->setEmail($email);
        $paiement->setMontant($montant);
        $paiement->setMethodePaiement($methode_paiement);
        $paiement->setStatut('en attente');
        $paiement->setNumeroCarteBleu($numero_carte_bleu); 
    
        $entityManager->persist($paiement);
        $entityManager->flush();
    
        
        $session->remove('panier');
    
        return $this->redirectToRoute('confirmation');
    }
    


    #[Route('/confirmation', name: 'confirmation')]
    public function confirmation(): Response
    {
        return $this->render('paiement/confirmation.html.twig');
    }
}
