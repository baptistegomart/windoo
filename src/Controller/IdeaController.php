<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use App\Repository\IdeaRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdeaController extends AbstractController
{
    /**
     * @Route("/idea", name="show_idea")
     */
    public function index(IdeaRepository $repo)
    {   
        $repo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $repo->findAll();

        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
            'ideas'=> $idea
        ]);

    }

    

    /**
     * @Route("/idea/order_by_rating", name="order_by_rating")
     */

    public function orderByRating(IdeaRepository $repo)
    {   
        $repo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $repo->findBy(
            array(),
             array('rating'=>'DESC')
         );

        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
            'ideas'=> $idea
        ]);

    }

    /**
     * @Route("/idea/order_by_date", name="order_by_date")
     */

    public function orderByDate(IdeaRepository $repo)
    {   
        $repo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $repo->findBy(
            array(),
             array('date'=>'DESC')
         );

        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
            'ideas'=> $idea
        ]);

    }

    /**
     * @Route("/new_idea", name="new_idea")
     */
    public function newIdea(Request $request , ObjectManager $manager) 

    {   
        $idea = new Idea();
        $form = $this->createForm(IdeaType::class, $idea); 

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            
            $idea->setDate(new \DateTime());
            $idea->setRating(0);

            $manager->persist($idea);
            $manager->flush();

            return $this->redirectToRoute('show_idea');
        }
      
        return $this->render('security/newidea.html.twig', [
            'form' => $form->createView()
        ]);


    
    }

/**
     * @Route("/idea/upvote/{id}", name="upvote")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
public function upvote($id)
{
$entitymManager = $this->getDoctrine()->getManager();
$idea = $entitymManager->getRepository(Idea::class)->find($id);


$rating = $idea->getRating();
$idea->setRating($rating + 1);
$entitymManager->flush();

return $this->redirectToRoute('show_idea');


}

/**
     * @Route("/idea/downvote/{id}", name="downvote")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function downvote($id)
    {
    $entitymManager = $this->getDoctrine()->getManager();
    $idea = $entitymManager->getRepository(Idea::class)->find($id);
    
    
    $rating = $idea->getRating();
    
    //one can't downvote an idea with a grade of 0
    if($rating === 0){
        $idea->setRating(0);
    } else {
        $idea->setRating($rating - 1);
    }

    $entitymManager->flush();
    
    return $this->redirectToRoute('show_idea');
    
    
    }



}
