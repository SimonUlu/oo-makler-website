<?php

namespace App\Services\OnOffice\Requests\Create;

use App\Services\OnOffice\Requests\AbstractRequest;

class Agentslog extends AbstractRequest
{
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_CREATE, 'agentslog');
    }

    public function setActionkind(string $actionkind): Agentslog
    {
        $this->parameters['actionkind'] = $actionkind;

        return $this;
    }

    public function setActiontype(string $actiontype): Agentslog
    {
        $this->parameters['actiontype'] = $actiontype;

        return $this;
    }

    public function setNote(string $note): Agentslog
    {
        $this->parameters['note'] = $note;

        return $this;
    }

    public function setEstateId(int $estateId): Agentslog
    {
        $this->parameters['estateid'] = $estateId;

        return $this;
    }
}
