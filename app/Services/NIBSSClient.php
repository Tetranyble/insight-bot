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

        $this->endpoint = config('services.nibss.ndd.base_url');
        $this->key = config('services.nibss.ndd.token');

        parent::__construct(array_merge([
            'base_uri' => $this->endpoint,
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // Force TLS 1.2
            ],
            //'debug' => true,
            'headers' => [
                'Authorization' => "Bearer $this->key",
                'Accept'        => 'application/json',
                //'Content-Type'  => 'application/x-www-form-urlencoded',
                'apikey' => config('services.nibss.ndd.api_key'),
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
    public function createEMandate(array $data): mixed
    {

        return $this->sends('POST', 'ndd/v2/api/MandateRequest/CreateEmandate', [
            'Content-Type' => 'application/json',
            'data' =>  $data
        ]);
    }

    /**
     * Get Biller products from NIBSS NDD
     *
     * @param integer $billerId
     * @return mixed
     * @throws GuzzleException
     */
    public function getProducts(int $billerId,array $data = [])
    {
        return $this->sends('GET', 'ndd/v2/api/Biller/GetProduct/'.$billerId, [
            'Content-Type' => 'application/json',
            'data' =>  $data
        ]);

    }

    /**
     * Create the biller. In this case Boctrust MFB
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     */
    public function createBiller(array $data): mixed
    {
        return $this->sends('POST', 'ndd/api/Biller/CreateBiller', [
            'Content-Type' => 'application/json',
            'data' =>  $data
        ]);
    }

    public function createProduct(array $data): mixed
    {
        return $this->sends('POST', 'ndd/api/Biller/CreateProduct', [
            'Content-Type' => 'application/json',
            'data' =>  $data
        ]);
    }

    /**
     * Call this endpoint whenever the token expires
     * that when you get 403 response on any request
     *
     * @throws GuzzleException
     */
    public function reset( array $options = []): mixed
    {
        return $this->sends('POST', 'v2/reset', [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'data' => array_merge([
                'client_Id'     => config('services.nibss.ndd.client_id'),
                'scope'         => config('services.nibss.ndd.client_id').'/.default',
                'grant_type'    => 'client_credentials',
                'client_secret' => config('services.nibss.ndd.client_secret'),
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
        try {
            $response = $this->request(
                $method,
                $uri,
                $this->createRequestOptions(
                    $options['Content-Type'],
                    $options['data']
                )
            )->getBody();

            return $this->prepareResponse($response);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Check for 403 response code
//            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 401) {
//
//                $resetResponse = $this->reset();
//                $newToken = $resetResponse->access_token;
//
//                // Update the Authorization header with the new token
//                $this->setKey($newToken);
//                $response = $this->request(
//                    $method,
//                    $uri,
//                    $this->createRequestOptions(
//                        $options['Content-Type'],
//                        $options['data']
//                    )
//                )->getBody();
//
//                return $this->prepareResponse($response);
//            }

            throw $e;
        }
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
        $this->updateAuthorizationHeader($key);
        return $this;
    }

    /**
     * Update the Authorization header
     */
    private function updateAuthorizationHeader(string $token): void
    {
        $this->config['headers']['Authorization'] = "Bearer $token";
    }

}
