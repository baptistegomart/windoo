<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdeaController extends AbstractController
{
    /**
     * @Route("/idea", name="show_idea")
     */
    public function index(IdeaRepository $repo)
    {   

        $idea = $repo->findBy(
            
            ['rating'=>'DESC']
        );

        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
            'ideas'=> $idea
        ]);

    }


}
