<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(IdeaRepository $repo)
    {

        $repo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $repo->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'ideas'=> $idea
        ]);
    }

    /**
     * @Route("/admin/order_by_rating", name="admin_order_by_rating")
     */

    public function orderByRating(IdeaRepository $repo)
    {   
        $repo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $repo->findBy(
            array(),
             array('rating'=>'ASC')
         );

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'IdeaController',
            'ideas'=> $idea
        ]);

    }

    /**
     * @Route("/admin/order_by_date", name="admin_order_by_date")
     */

    public function orderByDate(IdeaRepository $repo)
    {   
        $repo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $repo->findBy(
            array(),
             array('date'=>'DESC')
         );

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'IdeaController',
            'ideas'=> $idea
        ]);

    }


    /**
     * @Route("/admin/delete_idea/{id<\d+>}", name="delete_idea")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
 
    public function deleteIdea(
        Idea $idea,
        ObjectManager $objectManager
    )
    {
        
        $objectManager->remove($idea);
        $objectManager->flush();
        
        $this->addFlash(
            'success',
            'L\idée a bien été supprimée !'
        );
        
        return $this->redirectToRoute('admin');
    }

    
}
