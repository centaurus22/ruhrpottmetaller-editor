<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\HighLevel\NullBand;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseBandQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxBandOptionsDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseBandQueryModel $bandQueryModel;
    private RmString $bandFirstChar;
    private AbstractRmInt $bandId;

    public function __construct(
        View $view,
        DatabaseBandQueryModel $bandQueryModel,
        RmString $bandFirstChar,
        AbstractRmInt $bandId
    ) {
        parent::__construct($view);
        $this->bandQueryModel = $bandQueryModel;
        $this->bandFirstChar = $bandFirstChar;
        $this->bandId = $bandId;
    }

    protected function prepareThisController(): void
    {
        if ($this->bandFirstChar->get() === '') {
            $bands = RmArray::new()
                ->add(NullBand::new())
                ->add(Band::new()->setId(RmInt::new(1))->setName(RmString::new('Unknown')));
        } elseif ($this->bandFirstChar->get() === '%') {
            $bands = $this->bandQueryModel->getBandsWithSpecialChar();
        } else {
            $bands = $this->bandQueryModel->getBandsByFirstChar($this->bandFirstChar);
        }
        $bandNew = Band::new()->setId(RmInt::new(3))->setName(RmString::new('New Band'));
        $bands->add($bandNew);
        $this->view->set('bands', $bands);
        $this->view->set('bandId', $this->bandId);
    }
}
