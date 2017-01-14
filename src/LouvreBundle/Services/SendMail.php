<?php
// src/LouvreBundle/Services/sendMail.php
namespace LouvreBundle\Services;
use Swift_Mailer;
use Swift_Message;
use Swift_Attachment;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Session\Session;

class SendMail
{
    private $mailer;
    private $templating;

    public function __construct(Swift_Mailer $mailer, TwigEngine $engine)
    {
        $this->mailer = $mailer;
        $this->templating = $engine;
    }

    public function sendMail($panier)
    {
        $session = new Session();
        $panier = $session->get('panier');
        
        $message = Swift_Message::newInstance()
            ->attach(Swift_Attachment::fromPath(__DIR__ . 'Billet/Billet.pdf'))
            ->setSubject('Votre billet de visite')
            ->setFrom('louvre@sylvestre-cao.fr')
            ->setTo($panier['email'])
            ->setBody($this->templating->render('LouvreBundle:Louvre:mail.html.twig', array('panier' => $panier)),
                'text/html'
            );
        $this->mailer->send($message);
    }

}