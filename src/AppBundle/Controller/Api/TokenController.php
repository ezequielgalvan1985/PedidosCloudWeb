<?php
namespace AppBundle\Controller\Api;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use  \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TokenController extends Controller
{

    
    /**
     * @Route("/api/tokens")
     * @Method("POST")
     */
    public function newTokenAction(Request $request)
    {
        
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findOneBy(['username' => $request->get('username')]);
        
        if (!$user) {
            throw $this->createNotFoundException();
        }
        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $request->get('password'));
        if (!$isValid) {
            throw new BadCredentialsException();
        }
        
        
        $token = $this->get('lexik_jwt_authentication.encoder')->encode(['username' => $user->getUsername(),'exp' => time() + 3600]);
        return new JsonResponse(['token' => $token]);
    }
}