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
                'Authorization' => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6Ikg5bmo1QU9Tc3dNcGhnMVNGeDdqYVYtbEI5dyJ9.eyJhdWQiOiJlYzY5MWQ1NC0xMjcwLTQ2MDMtODg0MS1jZjcwMDEyNWFhMTIiLCJpc3MiOiJodHRwczovL2xvZ2luLm1pY3Jvc29mdG9ubGluZS5jb20vMjc5YzdiMWItYmEwNi00MjdiLWE2ODEtYzhhNTQ5MmQyOTNkL3YyLjAiLCJpYXQiOjE3MjU1Mzg3OTgsIm5iZiI6MTcyNTUzODc5OCwiZXhwIjoxNzI1NTQyNjk4LCJhaW8iOiJFMmRnWU9EbnF0RitkdjZDR2YvTmMvMUhCRFlWOGh5Sml6NzgwVUZUOU16YlQrZDRKZVFCIiwiYXpwIjoiZWM2OTFkNTQtMTI3MC00NjAzLTg4NDEtY2Y3MDAxMjVhYTEyIiwiYXpwYWNyIjoiMSIsInJoIjoiMC5BWUlBRzN1Y0p3YTZlMEttZ2NpbFNTMHBQVlFkYWV4d0VnTkdpRUhQY0FFbHFoS0NBQUEuIiwidGlkIjoiMjc5YzdiMWItYmEwNi00MjdiLWE2ODEtYzhhNTQ5MmQyOTNkIiwidXRpIjoiempxQlpvbnpHVUNMbEFjODhqR2tBQSIsInZlciI6IjIuMCJ9.h5rSAOZ2QhaP7xfzDEVGc7iOj7RtAvpS5WEd-LiqHH0VFrkKPTDiNjpVfqJeJvXLBVSyCqhJLiunHFvdCztpGx7C0YAM768tHU4nAFnJ7_6miqSXAeCafnQTV5m70usIavnuwM2owL4ysRRWt-rTWrrlgA9C_UiLTg2siWicdVxSS8qY7caLtk9I8QmRlhIMruzYKxtE_3l1eH3dTLqXdwTU6cT-wqZFnjonOn2wye9pZ0pjD07qT9hTrYyoO1WUpf2FdS4mlZDyiIpCXF7vM8PnwDk2ttloTLyfHjuBSA1gV323OUf36fiLVFENZb3_AWrlpR1xSmJxodvr34FI2A",
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
