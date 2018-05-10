<?php

namespace tests\Entity;
use App\Entity\Comments;
use PHPUnit\Framework\TestCase;

class CommentsTest extends TestCase
{
    public function testComments()
    {
        $comment = new Comments();
        $comment->setAuthor('Adrien');
        $comment->setArticleID(23);
        $comment->setContent('Commentaire');
        $comment->setSignalement(0);


        $this->assertEquals('Adrien', $comment->getAuthor());
        $this->assertEquals(23, $comment->getArticleID());
        $this->assertEquals('Commentaire', $comment->getContent());
        $this->assertEquals(0, $comment->getSignalement());
    }
}