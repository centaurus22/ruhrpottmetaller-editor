<?php

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;

echo RmDate::new($this->get('filterByParameter'))->getMonthChangerMenu();
