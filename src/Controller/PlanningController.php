<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Entity\PlanningResponse;
use App\Entity\User;
use App\Form\PlanningType;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/planning")
 * @IsGranted("ROLE_ADMINISTRATOR")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/", name="planning_index", methods={"GET"})
     */
    public function index(PlanningRepository $planningRepository): Response
    {
        return $this->render('planning/index.html.twig', [
            'plannings' => $planningRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="planning_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($planning);
            $entityManager->flush();

            return $this->redirectToRoute('planning_index');
        }

        return $this->render('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="planning_show", methods={"GET"})
     */
    public function show(Planning $planning): Response
    {
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="planning_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Planning $planning): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planning_index');
        }

        return $this->render('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="planning_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Planning $planning): Response
    {
        if ($this->isCsrfTokenValid('delete' . $planning->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($planning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planning_index');
    }

    /**
     * @Route("/email/{id}", name="planning_email")
     */
    public function email(Request $request, Planning $planning, \Swift_Mailer $mailer)
    {

        $name = 'Meriem';
        // on charge la librairie doctrine et on fait appelle au manager de la librairie doctrine
        $em = $this->getDoctrine()->getManager();
        // on souhaite charger l'entité "planning" et on fait appelle à notre méthode (fonction query builder customiser)
        // em = entitté manager
        $datas = $em->getRepository(User::class)->findAllEmailFromUserToPlanning($planning->getId());

        $message = (new \Swift_Message('Prochain Tournoi'))
            ->setFrom('entraineur@footclub.fr')
            ->setTo('parent@to.fr')
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/tournois.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            );

        foreach ($datas as $data) {
            // dump($data);
            $message->setTo($data['email']);
            $mailer->send($message);
        }


        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }


    /**
     * @Route("/participation/{id}", name="planning_participation")
     */
    public function participation(Request $request, Planning $planning)
    // $request = tout ce que reçoit le navigateur comme variable et autres osit tout le projet
    {
        $planningResponse = new PlanningResponse;

        // creates a task object and initializes some data for this example
        $form = $this->createFormBuilder($planningResponse)
            ->add('placeDisponible')

            //Champ customisé pour permettre le choix du jour 1
            ->add('jour1', CheckboxType::class, [
                'label' => 'Jour 1',
                //Ignore le champ customisé et non définit dans l'entité
                'mapped' => false,
                //La checkbox n'est pas obligatoire, le required est à false
                'required' => false
            ])
            //Champ customisé pour permettre le choix du jour 2
            ->add('jour2', CheckboxType::class, [
                'label' => 'Jour 2',
                //Ignore le champ qui est customisé et non définit dans l'entité
                'mapped' => false,
                //La checkbox n'est pas obligatoire, le required est à false
                'required' => false
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();
            // on ajoute la valeur planning
            $task->setPlanning($planning);
            // on ajoute également la valeur du user connecté
            $task->setUser($this->getUser());
            $jour1 = $form->get('jour1')->getData();
            $jour2 = $form->get('jour2')->getData();
            $present =['j1'=>$jour1 ,'j2'=> $jour2];
            $task->setPresent($present);
            
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            // return $this->redirectToRoute('task_success');
        }

        return $this->render('planning/participation.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
