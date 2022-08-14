<?php

namespace ruhrpottmetaller\LowLevel;

use ruhrpottmetaller\Data\LowLevel\RmArray;
use ruhrpottmetaller\Data\LowLevel\RmString;

include('vendor/autoload.php');

$HighLevelArray = RmArray::new()->add(RmString::new('Hello'))
    ->add(RmString::new(' World!'));
$HighLevelArray->getCurrent()->print();
$HighLevelArray->pointAtNext()->getCurrent()->print();

//Prints 'Hello World' to the terminal.
