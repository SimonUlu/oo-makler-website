<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class Calendar extends AbstractRequest
{
    const COLUMNS = [
        'start_dt',
        'end_dt',
    ];

    /**
     * Calendars constructor.
     */
    public function __construct($resourceId = null)
    {
        parent::__construct(self::ACTION_ID_READ, 'calendar');

        // defaults
        $this->setShowCancelled(true);
        $this->showConfirmationStatus(true);
        $this->setShowAllUsers(true);

        if ($resourceId) {
            $this->setResourceId($resourceId);
        }
    }

    public function setModifiedStart(string $start): Calendar
    {
        $this->parameters['modifiedstart'] = $start;

        return $this;
    }

    public function setModifiedEnd(string $end): Calendar
    {
        $this->parameters['modifiedend'] = $end;

        return $this;
    }

    public function setFilter(string $column, array $filter): Calendar
    {
        $this->parameters['filter'][$column] = $filter;

        return $this;
    }

    public function setShowCancelled(bool $showCancelled): Calendar
    {
        $this->parameters['showcancelled'] = $showCancelled;

        return $this;
    }

    public function showConfirmationStatus(bool $showConfirmationStatus): Calendar
    {
        $this->parameters['showConfirmationStatus'] = $showConfirmationStatus;

        return $this;
    }

    public function setShowAllUsers(bool $showAllUsers): Calendar
    {
        $this->parameters['allusers'] = $showAllUsers;

        return $this;
    }

    public function setSortBy(string $column): Calendar
    {
        $this->parameters['sortby'] = $column;

        return $this;
    }

    public function setSortOrder(string $order = 'ASC'): Calendar
    {
        $this->parameters['sortorder'] = $order;

        return $this;
    }
}
