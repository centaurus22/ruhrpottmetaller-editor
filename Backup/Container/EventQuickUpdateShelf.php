<?php


namespace ruhrpottmetaller\Container;


class EventQuickUpdateShelf extends AbstractShelf
{
    protected function testBook(Book $book): bool
    {

        return false;
    }
}

