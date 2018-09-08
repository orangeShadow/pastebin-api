<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

use OrangeShadow\PastebinApi\ResponseChecking;

final class ResponseCheckingTest extends TestCase
{
    private $responseChecking ;

    public function setUp()
    {
        parent::setUp();

        $this->responseChecking = new ResponseChecking();
    }


    public function testIsBadRequestShouldReturnTrue()
    {
        $this->assertTrue($this->responseChecking->isBadRequest('Bad API request, invalid api_option'));
        $this->assertTrue($this->responseChecking->isBadRequest('Post limit, maximum pastes per 24h reached'));
    }

    public function testIsBadRequestShouldReturnFalse()
    {
        $this->assertFalse($this->responseChecking->isBadRequest('Some text done Bad API request, invalid api_option'));
        $this->assertFalse($this->responseChecking->isBadRequest('Some text done Post limit, maximum pastes per 24h reached'));
    }

    public function testIsNotFoundShouldReturnTrue()
    {
        $this->assertTrue($this->responseChecking->isNotFound('No pastes found.'));
    }

    public function testIsNotFoundShouldReturnFalse()
    {
        $this->assertFalse($this->responseChecking->isNotFound(' No pastes found .'));
    }

    public function testIsPasteRemoveShouldReturnTrue()
    {
        $this->assertTrue($this->responseChecking->isPasteRemove('Paste Removed'));
    }

    public function testIsPasteRemoveShouldReturnFalse()
    {
        $this->assertFalse($this->responseChecking->isPasteRemove(' Paste Removed.'));
    }

}