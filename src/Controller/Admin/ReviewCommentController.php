<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Message\CommentMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewCommentController extends AbstractController
{
    #[Route('/admin/review/comment/{id}', name: 'review_comment')]
    public function __invoke(
      Request $request, 
      Comment $comment, 
      WorkflowInterface $commentStateMachine,
      EntityManagerInterface $entityManager,
      MessageBusInterface $bus,
    ): Response {
      $accepted = !$request->query->getBoolean('reject');
      if ($commentStateMachine->can($comment, 'publish')) {
          $transition = $accepted ? 'publish' : 'reject';
      } elseif ($commentStateMachine->can($comment, 'publish_ham')) {
          $transition = $accepted ? 'publish_ham' : 'reject_ham';
      } else {
          return new Response('Comment already reviewed or not in the right state.');
      }
      $commentStateMachine->apply($comment, $transition);
      $entityManager->flush();
      if ($accepted) {
          $bus->dispatch(new CommentMessage($comment->getId()));
      }
      return $this->render('admin/review_comment.html.twig', ['transition' => $transition, 'comment' => $comment, ]);
    }
}
