<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:48 AM
 */

namespace App\Controller\Security;


use App\Form\Users\AddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users\UseCase\CreateUser;
use App\Entity\Users\UseCase\CreateUser\Responder;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateUser $createUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, CreateUser $createUser)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateUser\Command(
                $data['login'],
                $data['password'],
                $data['email']
            );
            $command->setResponder($this);

            $createUser->execute($command);

            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}