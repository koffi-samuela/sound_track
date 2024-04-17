<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\AlbumRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddCommentController extends AbstractController
{
    #[Route('/add/comment', name: 'app_add_comment')]
    public function index(EntityManagerInterface  $em,Request  $request,AlbumRepository  $albumRepository,UserRepository $userRepository): Response
    {
        // if (!$this->getUser()) {
        //     return $this->redirectToRoute('login');
        // }
        $comment = new Comment ();
        if ($request->isMethod('POST')) {
            $album_id = $_GET["album_id"];
            $album = $albumRepository->find(
                intval($album_id)
            );
            $user_find = $userRepository->find(
                $this->getUser()->getId()
            );
            
            $content = $request->request->get('content');
            // $content = $_POST['content'];
            $user = $this->getUser();
            // dd($user->getUsername(),);
           $user_id = $user->getId();
            // dd($request->request->all(),$content,$user->getId(),$album_id);
            $comment->setAlbum($album);
            $comment->setUser($user_find);
            $comment->setCreatedAt(new \DateTime());
            $comment->setContent(htmlspecialchars($content));
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Le commentaire a été ajouté avec succès.');
            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);

            // $comment->setAuthor($user);
            //insertion dans la bdd 
        }
        return $this->render('add_comment/index.html.twig', [
        
        ]);
    }
}
