<?php

namespace App\Services\OnOfficeApiService;

/**
 * Class AbstractRequest
 */
abstract class AbstractRequest
{
    const ACTION_ID_READ = 'urn:onoffice-de-ns:smart:2.5:smartml:action:read';

    const ACTION_ID_GET = 'urn:onoffice-de-ns:smart:2.5:smartml:action:get';

    const ACTION_ID_CREATE = 'urn:onoffice-de-ns:smart:2.5:smartml:action:create';

    const ACTION_ID_MODIFY = 'urn:onoffice-de-ns:smart:2.5:smartml:action:modify';

    protected $actionId;

    protected $resourceType;

    protected $resourceId;

    private $token;

    private $secret;

    protected $parameters = [];

    public function __construct($actionId, $resourceType, $parameters = [], ?int $resourceId = null)
    {
        $this->actionId = $actionId;
        $this->resourceType = $resourceType;
        $this->resourceId = $resourceId;
        $this->parameters = $parameters;
    }

    public function build()
    {
        $timestamp = time();

        $action = [
            'actionid' => $this->actionId,
            'resourceid' => $this->resourceId,
            'identifier' => '',
            'resourcetype' => $this->resourceType,
            'timestamp' => $timestamp,
            'hmac' => $this->createHmac('', $timestamp),
            'parameters' => $this->parameters,
        ];

        return [
            'token' => $this->token,
            'request' => [
                'actions' => [
                    $action,
                ],
            ],
        ];
    }

    /**
     * @see https://apidoc.onoffice.de/onoffice-api-request/request-elemente/action/
     *
     * @return string
     */
    public function createHmac(
        $identifier,
        $timestamp
    ) {
        $token = $this->token;
        $secret = $this->secret;
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

    /**
     * @return AbstractRequest
     */
    public function setResourceId(?int $resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * @return AbstractRequest
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return AbstractRequest
     */
    public function setSecret(string $secret)
    {
        $this->secret = $secret;

        return $this;
    }
}
