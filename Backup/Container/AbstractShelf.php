<?php

namespace ruhrpottmetaller\Container;

abstract class AbstractShelf
{
    protected array $bookList = array();
    protected int $bookCounter = 0;
    protected array $bookDefinition = [];
    protected array|null $bookDefinitionRequiredValues = null;

    public function addBook(Book $book): bool
    {
        $isValidBook = $this->testBook($book);
        if ($isValidBook) {
            $this->bookList[] = $book;
        }
        return $isValidBook;
    }

    public function getNextBook(): Book|bool
    {
        if ($this->bookCounter < count($this->bookList)) {
            $book = $this->bookList[$this->bookCounter];
            $this->bookCounter++;
            return $book;
        } else {
            return false;
        }
    }

    protected function testBook(Book $book): bool
    {
        if (is_null($this->bookDefinitionRequiredValues)) {
            $this->bookDefinitionRequiredValues = $this->getBookDefinitionRequiredValues();
        }

        if (count($this->bookDefinitionRequiredValues) > 0) {
            return $this->testBookCheckRequiredValues($book);
        } else {
            return true;
        }
    }

    private function getBookDefinitionRequiredValues(): array
    {
        $bookDefinitionRequiredStatus = array_combine(
            array_keys($this->bookDefinition),
            array_column($this->bookDefinition, "required")
        );
        return array_keys($bookDefinitionRequiredStatus,true, true);
    }

    private function testBookCheckRequiredValues(Book $book): bool
    {
        $isBookComplete = true;
        $dataRowKeys = array_keys($book->getDataRow());
        foreach ($this->bookDefinitionRequiredValues as $requiredValue)  {
            if (!in_array($requiredValue, $dataRowKeys)) {
                $isBookComplete = false;
            }
        }
        return $isBookComplete;
    }
}