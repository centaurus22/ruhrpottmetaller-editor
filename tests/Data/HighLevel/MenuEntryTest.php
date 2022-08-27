<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\MenuEntry;
use ruhrpottmetaller\Data\LowLevel\RmString;

final class MenuEntryTest extends TestCase
{
    private MenuEntry $MenuEntry;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\MenuEntry
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldPrintMenuEntry(): void
    {
        $this->MenuEntry = MenuEntry::new()
            ->setId(RmString::new('events'))
            ->setName(RmString::new('Events'));
        $this->expectOutputString('<li><a href="?display=events&amp;month=2022-10">Events</a></li>');
        $this->MenuEntry->print(RmString::new('2022-10'));
    }
}
