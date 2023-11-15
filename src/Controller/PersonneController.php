<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\SigninType;
use App\Form\SingupType;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PersonneController extends AbstractController
{
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }
    #[Route('/addPersonne', name: 'add_Personne')]
    public function addPersonne(EntityManagerInterface $entityManager, Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(SingupType::class, $personne);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($personne);
            $entityManager->flush();

            // Redirect to a success page or another route
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('Personne/addPersonne.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/showadmin', name: 'show_admin')]
    
    public function showadmin(PersonneRepository $personnerepository): Response
    {
        return $this->render('personne/showadmin.html.twig', [
            'users' => $personnerepository->findAll(),
        ]);
    }
    #[Route('/personne/edit/{id}', name: 'personne_edit')]
    public function editAuthor(Request $request, ManagerRegistry $manager, $id, PersonneRepository $personnerepository): Response
    {
        $em = $manager->getManager();

        $personne  = $personnerepository->find($id);
        $form = $this->createForm(SingupType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('show_admin');
        }
        return $this->renderForm('personne/adminedit.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }
    #[Route('/personne/delete/{id}', name: 'personne_delete')]

public function deleteUser(int $id, EntityManagerInterface $entityManager): Response
{
    $user = $entityManager->getRepository(Personne::class)->find($id);

    // Implement logic for deleting user
    $entityManager->remove($user);
    $entityManager->flush();

    return $this->redirectToRoute('show_admin');
}

}
   




