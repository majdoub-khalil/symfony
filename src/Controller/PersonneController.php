<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\CodeverifType;
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
use App\Form\EmailverifType;
use App\Form\ModifpassType;
use App\Service\MailService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;

class PersonneController extends AbstractController
{
    private function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }

    #[Route('/log', name: 'app_sig')]
    public function customLogin(Request $request): Response
    {
        $error = null;

        // Check if the form is submitted
        if ($request->isMethod('POST')) {
            // Retrieve email and password from the form
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Retrieve the user from the database based on the entered email
            $userRepository = $this->getDoctrine()->getRepository(Personne::class);
            $user = $userRepository->findOneBy(['email' => $email]);

            // Check if the user exists and the password is correct
            if ($user && password_verify($password, $user->getMotDePasse())) {
                // Redirect to a success page or perform any other action
                return $this->redirectToRoute('app_homepage');
            } else {
                // Invalid credentials, you might want to add an error message
                $error = 'Invalid email or password';
            }
        }

        return $this->render('Personne/login.html.twig', ['error' => $error]);
    }

    #[Route('/{_locale}/addPersonne', name: 'add_Personne')]
    public function addPersonne(EntityManagerInterface $entityManager, Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(SingupType::class, $personne);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();
            $badWords = ['badword', 'terror', 'mort'];
            if ($this->containsBadWords($nom, $badWords)) {
                $this->addFlash('error', 'The name contains inappropriate words.');
                return $this->redirectToRoute('add_Personne');
                
            }
            
            // Hash the password before saving it to the database
            $hashedPassword = password_hash($personne->getMotDePasse(), PASSWORD_BCRYPT);
            $personne->setMotDePasse($hashedPassword);
            $hashedPassword = password_hash($personne->getMotDePasse2(), PASSWORD_BCRYPT);
            $personne->setMotDePasse2($hashedPassword);
          

            $entityManager->persist($personne);
            $entityManager->flush();

            // Redirect to a success page or another route
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('Personne/addPersonne.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{_locale}/showadmin', name: 'show_admin')]
    public function showadmin(PersonneRepository $personnerepository): Response
    {
        return $this->render('personne/showadmin.html.twig', [
            'users' => $personnerepository->findAll(),
        ]);
    }

    #[Route('/{_locale}/personne/edit/{id}', name: 'personne_edit')]
    public function editAuthor(Request $request, ManagerRegistry $manager, $id, PersonneRepository $personnerepository): Response
    {
        $em = $manager->getManager();

        $personne = $personnerepository->find($id);
        $form = $this->createForm(SingupType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password before saving it to the database
            $hashedPassword = password_hash($personne->getMotDePasse(), PASSWORD_BCRYPT);
            $personne->setMotDePasse($hashedPassword);
            $hashedPassword = password_hash($personne->getMotDePasse2(), PASSWORD_BCRYPT);
            $personne->setMotDePasse2($hashedPassword);
          

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

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('show_admin');
    }
    private function containsBadWords($nom, $badWords)
    {
        $nom = strtolower($nom); // Convert to lowercase for case-insensitive check

        foreach ($badWords as $badWord) {
            if (strpos($nom, strtolower($badWord)) !== false) {
                return true;
            }
        }

        return false;
    }
  
    #[Route('/emailVerification', name: 'email_verification', methods: ['GET', 'POST'])]
public function emailVerification(Request $request,PersonneRepository $repo,MailerInterface $mailer, MailService $mailService): Response
{
    $code = $this->generateRandomString(6);

    $form1 = $this->createForm(EmailverifType::class);

    $form1->handleRequest($request);

    if ($form1->isSubmitted() && $form1->isValid()) {
       
        // Handle form submission if needed
        // For example, you can check the submitted email and send a verification email
        $enteredEmail = $form1->get('Email')->getData();
        $mailService->sendEmail($enteredEmail, 'Email Verification', "This is your code :  $code");
        $user = $repo->findOneBy(['email' => $enteredEmail]);
        $id=$user->getId();

        $this->addFlash('success', 'Verification email sent successfully.');

        // Redirect to a success page or another route
        return $this->redirectToRoute('code_verification', ['userId' => $id, 'verificationCode' => $code]);
        
    }

    return $this->render('personne/emailverif.html.twig', [
        'form1' => $form1->createView(),
    ]);
}
#[Route('/codeverif/{userId}/{verificationCode}', name: 'code_verification', methods: ['GET', 'POST'])]
public function codeverif(Request $request, int $userId, string $verificationCode): Response
{
    $form1 = $this->createForm(CodeverifType::class);

    $form1->handleRequest($request);

    if ($form1->isSubmitted() && $form1->isValid()) {
        $code = $form1->get('Code')->getData();
        if($code==$verificationCode){
            return $this->redirectToRoute('modif_verification', ['userId' => $userId]);

        }
        else{
            $this->addFlash('Verify the code sent to your email', 'Code Incorrect.');
        }
        
        // Handle form submission if needed
        // For example, you can check the submitted code and perform verification

     

        // Return the verification code in the response
       
    }

    return $this->render('personne/verifcode.html.twig', [
        'form1' => $form1->createView(),
        'userId' => $userId,
        'verificationCode' => $verificationCode,
    ]);
}


#[Route('/codemodif/{userId}', name: 'modif_verification', methods: ['GET', 'POST'])]
public function codemodif(Request $request, int $userId,ManagerRegistry $manager,PersonneRepository $repo): Response
{
    $form1 = $this->createForm(ModifpassType::class);

    $form1->handleRequest($request);
    $em = $manager->getManager();
    $personne = $repo->find($userId);
    $nom=$personne->getNom();
    if ($form1->isSubmitted()) {
        // Handle form submission if needed
        // For example, you can check the submitted data and update the password
         // Hash the password before saving it to the database
         $hashedPassword = password_hash($personne->getMotDePasse(), PASSWORD_BCRYPT);
         $personne->setMotDePasse($hashedPassword);
         $hashedPassword = password_hash($personne->getMotDePasse2(), PASSWORD_BCRYPT);
         $personne->setMotDePasse2($hashedPassword);
         $em->flush();
        $this->addFlash('success', 'Success.');

        // Redirect to a success page or another route
        return $this->redirectToRoute('app_homepage');
    }

    return $this->render('personne/modifpass.html.twig', [
        'form1' => $form1->createView(),
        'userId' => $userId,
        'nom'=>$nom,
        
    ]);
    
}



}