<?php

namespace App\MessageHandler;

use App\SpamChecker;
use App\Message\CommentMessage;
use App\Entity\Enum\CommentStateEnum;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CommentMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SpamChecker $spamChecker,
        private CommentRepository $commentRepository,
    ) {
    }
    public function __invoke(CommentMessage $message): void
    {
        $comment = $this->commentRepository->find($message->id);
        if (null === $comment) {
            return;
        }
        $comment->setState(CommentStateEnum::Published);
        if (2 === $this->spamChecker->getSpamScore($comment, $message->context)) {
            $comment->setState(CommentStateEnum::Spam);
        }
        $this->entityManager->flush();
    }
}
