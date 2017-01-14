<?php
// src/LouvreBundle/Services/CreatePdf.php
namespace LouvreBundle\Services;

use Symfony\Bundle\TwigBundle\TwigEngine;
use HTML2PDF;
use Symfony\Component\HttpFoundation\Session\Session;
class CreatePdf
{
    private $templating;

    public function __construct(TwigEngine $engine)
    {
        $this->templating = $engine;
    }

    public function createPdf($panier)
    {
        $session = new Session();
        $panier = $session->get('panier');

        $html = $this->templating->render('LouvreBundle:Louvre:pdfmail.html.twig', array('panier' => $panier));
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetTitle('Votre billet de visite');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $html2pdf->Output(__DIR__ . '/Billet/Billet.pdf', 'F');
    }

}