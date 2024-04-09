<?php

namespace ruhrpottmetaller\Controller\Display\Ajax;

use ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\HighLevel\NullBand;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\View\View;

class EditorAjaxNewLineupDisplayController extends AbstractDataMainDisplayController
{
    private SessionGigCommandModel $gigCommandModel;

    public function __construct(
        View $view,
        SessionGigCommandModel $gigCommandModel,
    ) {
        parent::__construct($view);
        $this->gigCommandModel = $gigCommandModel;
    }

    protected function prepareThisController(): void
    {
        $gigs = RmArray::new()->add(
            Gig::new()
            ->setBand(NullBand::new())
            ->setAdditionalInformation(RmNullString::new(null))
        );
        $this->gigCommandModel->load($gigs);
        $this->view->set('gigs', $gigs);
    }
}
