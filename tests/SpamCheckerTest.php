<?php

namespace App\Tests;

use App\Entity\Comment;
use App\SpamChecker;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SpamCheckerTest extends TestCase
{
    public function testSpamScoreWithInvalidRequest(): void
    {
        ($comment = new Comment())->setCreatedAtValue();
        $client = new MockHttpClient([new MockResponse('invalid', ['response_headers' => ['x-akismet-debug-help: Invalid key']])]);
        $checker = new SpamChecker($client, 'abcde');
        static::expectException(\RuntimeException::class);
        static::expectExceptionMessage('Unable to check for spam: invalid (Invalid key).');
        $checker->getSpamScore(comment: $comment, context: []);
    }

    // 3 test grace au dataprovider de php unit on lie la function provideComments ou se trouve les 3 parametre de test.
    #[DataProvider('provideComments')]
    public function testSpamScore(int $expectedScore, ResponseInterface $response, Comment $comment, array $context)
    {
        $client = new MockHttpClient([$response]);
        $checker = new SpamChecker($client, 'abcde');
        $score = $checker->getSpamScore($comment, $context);
        static::assertSame($expectedScore, $score);
    }

    /** @return iterable<string, array<mixed>> */
    public static function provideComments(): iterable
    {
        ($comment = new Comment())->setCreatedAtValue();
        $response = new MockResponse('', ['response_headers' => ['x-akismet-pro-tip: discard']]);
        yield 'blatant_spam' => [2, $response, $comment, []];
        $response = new MockResponse('true');
        yield 'spam' => [1, $response, $comment, []];
        $response = new MockResponse('false');
        yield 'ham' => [0, $response, $comment, []];
    }
}
