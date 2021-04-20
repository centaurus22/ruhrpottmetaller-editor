<?php

namespace ruhrpottmetaller\DataManagement;

abstract class AbstractDataShelf
{
    private array $bookList = array();
    private int $bookCounter = 0;
    private array $bookDefinition = [];

    public function addBook(array $book): bool
    {
        $this->bookList[] = $book;
        return true;
    }

    public function getNextBook(): mixed
    {
        if ($this->bookCounter < count($this->bookList)) {
            return $this->getBookByNumberAndUpdateBookCounter($this->bookCounter);
        } else {
            return false;
        }
    }

    private function testBook(array $book): bool
    {

    }

    private function getBookByNumberAndUpdateBookCounter(int $currentBookCounter)
    {
        $this->bookCounter = $currentBookCounter + 1;
        return $this->bookList[$currentBookCounter];
    }
}