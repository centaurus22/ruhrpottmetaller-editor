<?php

namespace ruhrpottmetaller\LowLevel;

use ruhrpottmetaller\Data\LowLevel\DataTypeArray;
use ruhrpottmetaller\Data\LowLevel\DataTypeString;

include('vendor/autoload.php');

$HighLevelArray = DataTypeArray::new()->add(DataTypeString::new('Hello'))
    ->add(DataTypeString::new(' World!'));
$HighLevelArray->get()->print();
$HighLevelArray->pointAtNext()->get()->print();

//Prints 'Hello World' to the terminal.
