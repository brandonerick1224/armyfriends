<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse extends JsonResponse
{

    /**
     * Constructor.
     *
     * @param  mixed  $data
     * @param  int    $status
     * @param  array  $headers
     * @param  int    $options
     */
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        $this->jsonOptions = $options;

        parent::__construct($data, $status, $headers);

        $this->headers->set('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
        $this->headers->set('Access-Control-Allow-Headers', $this->headers->get('Access-Control-Request-Headers'));
        $this->headers->set('Access-Control-Allow-Origin', '*');
    }

    /**
     * Get the json_decoded data from the response.
     *
     * @param bool $assoc
     * @param int  $depth
     * @return mixed
     */
    public function getData($assoc = false, $depth = 512)
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data = [])
    {
        $this->data = $data;

        return $this->update();
    }

    /**
     * Add new data
     *
     * @param array $data
     * @return $this
     */
    public function addData($data = [])
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Disable content
     *
     * @param mixed $content Content that can be cast to string
     * @return Response
     */
    public function setContent($content)
    {
        return $this;
    }

    /**
     * Gets the current response content.
     *
     * @return string Content
     */
    public function getContent()
    {
        return json_encode($this->data);
    }

    /**
     * Sends content for the current web response,
     * send encoded json
     *
     * @return Response
     */
    public function sendContent()
    {
        $data = ['result' => $this->data];

        echo json_encode($data);

        return $this;
    }
}
