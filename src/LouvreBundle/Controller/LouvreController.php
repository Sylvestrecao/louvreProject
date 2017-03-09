<?php

namespace LouvreBundle\Controller;

use LouvreBundle\Entity\Clients;
use LouvreBundle\Entity\Commandes;
use LouvreBundle\Form\ClientsType;
use LouvreBundle\Form\CommandesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Omnipay\Omnipay;

class LouvreController extends Controller
{
    public function pdfAction(Request $request, $token)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('LouvreBundle:Commandes')->getCommandeToken($token);

        $html = $this->render('LouvreBundle:Louvre:pdf.html.twig', array(
          'produit' => $produit
        ));
        
        $html2pdf = new \HTML2PDF('P','A4','fr');
        $html2pdf->pdf->SetTitle('Billet Louvre');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);

        return new Response($html2pdf->Output('Billet.pdf'), 200, array(
            'Content-Type' => 'application/pdf'
        ));
    }
    
    public function indexAction()
    {
        return $this->render('LouvreBundle:Louvre:index.html.twig');
    }

    public function billeterieAction(Request $request)
    {
        $session = $request->getSession();
        $session->remove('panier');
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('LouvreBundle:Produits')->findAll();
        
        return $this->render('LouvreBundle:Louvre:billeterie.html.twig', array('produits' => $produits));
    }
    
    public function detailAction(Request $request, $id)
    {
        $session = $request->getSession();
        $session->remove('panier');
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('LouvreBundle:Produits')->find($id);

        $billet = new Commandes();
        $form = $this->get('form.factory')->create(CommandesType::class, $billet, array(
            'tarif' => $produit->getDescription(),
            'tarif_value' => $produit->getNom()
        ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $session = $request->getSession();
            if (!$session->has('panier')) {
                $session->set('panier', array());
            }
            $panier = $session->get('panier');
            $panier['type'] = $billet->getType();
            $panier['produit'] = $produit->getNom();
            $panier['date_reservation'] = $billet->getJour();
            $panier['quantite'] = $billet->getQuantite();
            $panier['produit_id'] = $produit->getId();
            $session->set('panier',$panier);
            return $this->redirectToRoute('louvre_ajouter', array('id' => $produit->getId()));
        }
        return $this->render('LouvreBundle:Louvre:detail.html.twig', array(
            'form'    => $form->createView(),
            'produit' => $produit
        ));
    }
    public function ajouterAction(Request $request, $id)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) {
            $session->set('panier', array());
        }
        $panier = $session->get('panier');

        // Récupère le prix du produit via la bdd
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('LouvreBundle:Produits')->find($id);
        $prix = $produit->getPrix();
        // Attribution du prix dans la session
        if($panier['type'] == "Demi-Journée") {
            $panier['prix'] = $prix / 2;
            $panier['amount'] = $prix * $panier['quantite'] / 2;
        }
        else{
            $panier['prix'] = $prix;
            $panier['amount'] = $prix * $panier['quantite'];
        }
        $session->set('panier',$panier);
        
        return $this->redirect($this->generateUrl('louvre_panier'));
    }

    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');
        
        $id = $panier['produit_id'];
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('LouvreBundle:Produits')->find($id);
        
        return $this->render('LouvreBundle:Louvre:panier.html.twig', array(
          'produit' => $produit,
          'panier'  => $panier
        ));
    }

    public function coordonneesAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('LouvreBundle:Produits')->find($panier['produit_id']);

        $coordonnees = new Clients();
        $form = $this->get('form.factory')->create(ClientsType::class, $coordonnees);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $panier['nom'] = $coordonnees->getNom();
            $panier['prenom'] = $coordonnees->getPrenom();
            $panier['pays'] = $coordonnees->getPays();
            $panier['birthday'] = $coordonnees->getBirthday();
            $panier['email'] = $coordonnees->getMail();
            $session->set('panier',$panier);
            
           return $this->redirectToRoute('louvre_select_paiement');
        }

        return $this->render('LouvreBundle:Louvre:coordonnees.html.twig', array(
            'form'    => $form->createView(),
            'produit' => $produit,
            'panier'  => $panier
        ));
    }

    public function paiementselectAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('LouvreBundle:Produits')->find($panier['produit_id']);

        return $this->render('LouvreBundle:Louvre:select_paiement.html.twig', array(
            'produit' => $produit,
            'panier' => $panier
        ));
    }

    public function successstripeAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');

        if($request->isMethod('POST')){
            $token = $_POST['stripeToken'];
            $gateway = Omnipay::create('Stripe');
            $gateway->setApiKey($this->getParameter('stripe_key'));
            $response = $gateway->purchase(['amount' => $panier['amount'], 'currency' => 'EUR', 'token' => $token])->send();

            if($response->isSuccessful()){
                $panier['token'] = $token;
                $session->set('panier', $panier);

                $billet = $this->container->get('insertData');
                $billet->insertData($panier);

                $pdf = $this->container->get('createPdf');
                $pdf->createPdf($panier);
               
                $mail = $this->container->get('sendMail');
                $mail->sendMail($panier);

                return $this->render('LouvreBundle:Louvre:paiement.html.twig', array('panier' => $panier));
            }
            else{
                return $this->redirectToRoute('louvre_homepage');
            } 
        }
        else{
            return $this->redirectToRoute('louvre_homepage');
        }
        return $this->render('LouvreBundle:Louvre:index.html.twig');
    }

    public function paiementAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');
        $montant = $panier['amount'];
     
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername("marc_api1.doe.com");
        $gateway->setPassword($this->getParameter('paypal_password'));
        $gateway->setSignature($this->getParameter('paypal_signature'));
        $gateway->setTestMode(true);

        $response = $gateway->purchase(
            array(
                'cancelUrl'=>'http://www.louvre.sylvestre-cao.fr/paiement_select',
                'returnUrl'=>'http://www.louvre.sylvestre-cao.fr/paiement_success',
                'description'=>'TEST VENTE',
                'amount'=> $montant,
                'currency'=>'EUR'
            )
        )->send();
        
        $response->redirect();
        return $this->render('LouvreBundle:Louvre:paiement.html.twig');
    }

    public function successAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');
         if(isset($panier['refresh'])){
            session_destroy();
            return $this->redirectToRoute('louvre_billeterie');
        }
        $montant = $panier['amount'];

        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername("marc_api1.doe.com");
        $gateway->setPassword($this->getParameter('paypal_password'));
        $gateway->setSignature($this->getParameter('paypal_signature'));
        $gateway->setTestMode(true);

        $response = $gateway->completePurchase(array('amount'=> $montant, 'currency'=>'EUR'))->send();
        $data = $response->getData();
        
        if($response->isSuccessful()){
            $panier['token'] = $data['TOKEN'];
            $panier['refresh'] = 1;
            $session->set('panier',$panier);
        
            $billet = $this->container->get('insertData');
            $billet->insertData($panier);

            $pdf = $this->container->get('createPdf');
            $pdf->createPdf($panier);
           
            $mail = $this->container->get('sendMail');
            $mail->sendMail($panier);

            return $this->render('LouvreBundle:Louvre:paiement.html.twig', array('panier' => $panier));
        }
        return $this->render('LouvreBundle:Louvre:index.html.twig');
    }
}
