<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use App\Repository\IdeaRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
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

            $manager->persist($idea);
            $manager->flush();

            return $this->redirectToRoute('show_idea');
        }
      
        return $this->render('security/newidea.html.twig', [
            'form' => $form->createView()
        ]);


    
    }

    // /**
    //  * @Route("/idea/upvote/{id}", name="upvote")
    //  */

    // public function upvote($id)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $idea = $em->getRepository(Idea::class)->find($id);
    //         // $rating = $this->getRating();
    //         $idea = setRating(rating + 1);
    //         $em->flush();

    //         return $this->redirectToRoute('show_idea', [
    //             'ideas'=>$idea
    //         ]);
    //     }
    

    // public function downvote(IdeaRepository $repo)
    // {   
    //     $repo = $this->getDoctrine()->getRepository(Idea::class);
    //     $idea = $repo->findBy(
    //         array(),
    //          array('date'=>'DESC')
    //      );

    //     return $this->render('idea/index.html.twig', [
    //         'controller_name' => 'IdeaController',
    //         'ideas'=> $idea
    //     ]);

    // }

}
