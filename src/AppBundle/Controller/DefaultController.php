<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Contact;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $contact = new Contact();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $contact);
            
        $formBuilder
            ->add('name',   TextType::class, 
                array(
                    'label' => 'Votre nom*',
                    'label_attr' => array(
                        'class' => 'mb-0 mt-2'
                    ),
                    'attr'  => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add('email',  EmailType::class, 
                array(
                    'label' => 'Votre email*',
                    'label_attr' => array(
                        'class' => 'mb-0 mt-2'
                    ),
                    'attr'  => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add('message',   TextAreaType::class, 
                array(
                    'label' => 'Votre message*',
                    'label_attr' => array(
                        'class' => 'mb-0 mt-2'
                    ),
                    'attr'  => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add('submit', SubmitType::class,
                array(
                  'label' => 'Envoyer',
                  'attr' => array(
                    'class' => 'mt-3 btn btn-info'
                    )
                )
              );

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) { 
              $message = (new \Swift_Message('Message du site wwwthibaultfiacre.com'))
                        ->setFrom($contact->getEmail())
                        ->setTo('thibault.fiacre@mail.com')
                        ->setBody(
                            $this->renderView(
                                'default/email.html.twig',
                                array('contact' => $contact)
                            )
                        );
                        $this->addFlash('Success', 'Votre message a bien été envoyé, je vous en remercie et vous répondrai dans les meilleurs délais !');
                return $this->render('default/index.html.twig', array('form' => $form->createView()));
            } else { 
                $this->addFlash('Error', 'Une erreur s\'est produite, veuillez reessayer !');
                return $this->render('default/index.html.twig', array('form' => $form->createView()));
            }
        } else {
            return $this->render('default/index.html.twig', array('form' => $form->createView()));
        }
    } //End indexAction

    public function servicesAction(Request $request)
    {
        return $this->render('default/services.html.twig');
    }
}
