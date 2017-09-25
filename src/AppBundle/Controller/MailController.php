<?php
// tests/AppBundle/Controller/MailControllerTest.php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class MailController extends Controller
{
    /**
     * @Route("/enviar", name="email_enviar")
     * @Method("GET")
     */
    public function sendEmailAction( \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('ezgatrabajo@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        $mailer->send($message);

        return $this->render('email/enviar.html.twig');
    }
}