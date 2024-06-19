<?php

namespace App\Services\OnOffice\Requests;

/**
 * Class AbstractRequest
 */
abstract class AbstractRequest
{
    public const ACTION_ID_CREATE = 'urn:onoffice-de-ns:smart:2.5:smartml:action:create';

    public const ACTION_ID_DELETE = 'urn:onoffice-de-ns:smart:2.5:smartml:action:delete';

    public const ACTION_ID_MODIFY = 'urn:onoffice-de-ns:smart:2.5:smartml:action:modify';

    public const ACTION_ID_READ = 'urn:onoffice-de-ns:smart:2.5:smartml:action:read';

    public const ACTION_ID_GET = 'urn:onoffice-de-ns:smart:2.5:smartml:action:get';

    public const ACTION_ID_DO = 'urn:onoffice-de-ns:smart:2.5:smartml:action:do';

    public function __construct(
        private readonly string $actionId,
        private readonly string $resourceType,
        protected array $parameters = [],
        private ?string $resourceId = null
    ) {}

    public function build(string $token, string $secret): array
    {
        $timestamp = time();

        return [
            'actionid' => $this->actionId,
            'resourceid' => $this->resourceId ?? '',
            'identifier' => '',
            'resourcetype' => $this->resourceType,
            'timestamp' => $timestamp,
            'hmac' => $this->createHmac($token, $secret, '', $timestamp),
            'parameters' => $this->parameters,
        ];
    }

    /**
     * @see https://apidoc.onoffice.de/onoffice-api-request/request-elemente/action/
     *
     * @return string
     */
    public function createHmac(
        $token,
        $secret,
        $identifier,
        $timestamp
    ) {
        $parameters = $this->parameters;
        $id = $this->resourceId;
        $type = $this->resourceType;
        $actionId = $this->actionId;

        // in alphabetical order
        $fields['accesstoken'] = $token;
        $fields['actionid'] = $actionId;
        $fields['identifier'] = $identifier;
        $fields['resourceid'] = $id;
        $fields['secret'] = $secret;
        $fields['timestamp'] = $timestamp;
        $fields['type'] = $type;

        ksort($parameters);

        $parametersBundled = json_encode($parameters);
        $fieldsBundled = implode(',', $fields);
        $allParams = $parametersBundled.','.$fieldsBundled;

        return md5($secret.md5($allParams));
    }

    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }
}
