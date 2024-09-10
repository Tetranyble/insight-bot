<?php

namespace App\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
class NIBSSClient extends Client
{
    protected string $key;

    protected string $endpoint;


    public function __construct(array $config = [])
    {

        $this->endpoint = config('services.nibss.base_url');
        $this->key = '';
        parent::__construct(array_merge([
            'base_uri' => $this->endpoint,
            'headers' => [
                'Authorization' => "Bearer ",
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'apikey' => config('services.nibss.api_key'),
            ],
        ], $config));

    }

    /**
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     */
    public function createMandateDirectDebit(array $data): mixed
    {

        return $this->sends('POST', 'ndd/v2/api/MandateRequest/CreateMandateDirectDebit', [
            'Content-Type' => 'multipart/form-data',
            'data' =>  $data
        ]);
    }

    /**
     * Get comments
     *
     * @throws GuzzleException
     */
    public function reset( array $options = []): mixed
    {
        return $this->sends('POST', 'v2/reset', [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'data' => array_merge([
                'client_Id'     => config('services.nibss.client_id'),
                'scope'         => config('services.nibss.client_id').'/.default',
                'grant_type'    => 'client_credentials',
                'client_secret' => config('services.nibss.client_secret'),
            ], $options)
        ]);
    }


    /**
     * Default request handler
     *
     * @throws GuzzleException
     */
    public function sends(string $method, string $uri, array $options = []): mixed
    {

        $response = $this->request(
            $method,
            $uri,
            $this->createRequestOptions(
                $options['Content-Type'],
                $options['data']
            )
        )->getBody();

        return $this->prepareResponse($response);
    }

    /**
     * Get json response of the request
     */
    private function prepareResponse($response): mixed
    {
        return json_decode($response->getContents());
    }


    /**
     * @param string $contentType
     * @param array $data
     * @return array
     */
    private function createRequestOptions(string $contentType, array $data): array
    {
        switch ($contentType) {
            case 'application/json':
                return [
                    'headers' => ['Content-Type' => $contentType],
                    'json' => $data,
                ];

            case 'application/x-www-form-urlencoded':
                return [
                    'headers' => ['Content-Type' => $contentType],
                    'form_params' => $data,
                ];

            case 'multipart/form-data':
                $multipartData = [];
                foreach ($data as $name => $contents) {
                    if (is_array($contents) && isset($contents['contents'])) {
                        // Handling file uploads
                        $multipartData[] = [
                            'name'     => $name,
                            'contents' => $contents['contents'],
                            'filename' => $contents['filename'] ?? null,
                        ];
                    } else {
                        // Handling regular form data
                        $multipartData[] = [
                            'name'     => $name,
                            'contents' => $contents,
                        ];
                    }
                }
                return [
                    'headers' => ['Content-Type' => $contentType],
                    'multipart' => $multipartData,
                ];
            case 'text/plain':
                return [
                    'headers' => ['Content-Type' => $contentType],
                    'body' => is_array($data) ? implode("\n", $data) : $data,
                ];
            default: // For custom or raw data
                return [
                    'headers' => ['Content-Type' => $contentType],
                    'body' => is_array($data) ? http_build_query($data) : $data,
                ];
        }
    }

    /**
     * @param string $key
     * @return NIBSSClient
     */
    public function setKey(string $key): NIBSSClient
    {
        $this->key = $key;
        return $this;
    }

}
