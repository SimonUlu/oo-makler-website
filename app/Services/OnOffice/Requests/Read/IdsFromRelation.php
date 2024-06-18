<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class IdsFromRelation extends AbstractRequest
{
    const RELATION_ESTATE_ADDRESS_ALL = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:contactPersonAll';

    const RELATION_ESTATE_ADDRESS_OWNER = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:owner';

    const RELATION_ESTATE_ADDRESS_CONTACT_PERSON = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:contactPerson';

    const RELATION_ESTATE_INTERESTED = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:interested';

    const RELATION_ADDRESS_ESTATE_OFFER = 'urn:onoffice-de-ns:smart:2.5:relationTypes:address:estate:offer';

    const RELATION_USER_ADDRESS = 'urn:onoffice-de-ns:smart:2.5:relationTypes:user:address';

    /**
     * Estates constructor.
     */
    public function __construct(string $relationType, array $parentIds = [], array $childIds = [])
    {
        parent::__construct(self::ACTION_ID_GET, 'idsfromrelation');

        $this->parameters['relationtype'] = $relationType;
        if (! empty($parentIds)) {
            $this->parameters['parentids'] = $parentIds;
        }
        if (! empty($childIds)) {
            $this->parameters['childids'] = $childIds;
        }
    }
}
