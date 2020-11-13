<?php

switch($this->_['display']) {
    case 'city':
        $data = array (
            1 => array('name' => 'Name', 'db_ref' => 'name', 'type' => 'string'),
        );
        break;
    case 'venue':
        $data = array (
            1 => array(
                'name' => 'Name',
                'db_ref' => 'name',
                'type' => 'string'
            ),
            2 => array(
                'name' => 'Venue',
                'db_ref' => 'venue_name',
                'type' => 'string'
            ),
            3 => array(
                'name' => 'Standard URL',
                'db_ref' => 'url',
                'type' => 'string'
            ),
            4 => array(
                'name' => 'Export',
                'db_ref' => 'anzeigen',
                'type' => 'bool'
            ),
        );
        break;
    case 'band':
        $data = array (
            1 => array('name' => 'Name', 'db_ref' => 'name', 'type' => 'string'),
            2 => array('name' => 'Nazi', 'db_ref' => 'nazi', 'type' => 'bool')
        );
        break;
}
