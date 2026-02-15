<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait APIResponse
{
    /**
     * Max number of returned resources.
     *
     * @var int
     */
    protected $limit = 10;

    /**
     * Status code.
     *
     * @var int
     */
    protected int $statusCode = Response::HTTP_OK;

    /**
     * Set status code.
     *
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the value of status code.
     *
     * @return Integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        $code = $this->getStatusCode();

        return Response::$statusTexts[$code];
    }

    /**
     * The general form of respond.
     *
     * @return JsonResponse
     */
    public function respond(array $data, array $headers = []): JsonResponse
    {
        return response()->json(
            $data,
            $this->getStatusCode(),
            $headers
        );
    }

    /**
     * @param $data
     *
     * @return JsonResponse
     */
    public function respondOK($data = []): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($data);
    }

    /**
     * @param $data
     *
     * @return JsonResponse
     */
    public function respondBadRequest($data = []): JsonResponse
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
            ->respond(['errors' => $data]);
    }

    /**
     * @param $message
     *
     * @return JsonResponse
     */
    public function respondOKWithMessage($message): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond([
                'message' => $message,
            ]);
    }

    /**
     * @param $message
     * @param $additional
     *
     * @return JsonResponse
     */
    public function respondWithError($message, $additional = null): JsonResponse
    {
        $response = [
            'error' => [
                'status' => $this->getStatusText(),
                'message' => $message,
                'code' => Response::HTTP_BAD_REQUEST,
            ],
        ];

        if ($additional) {
            $response['error'] = array_merge($response['error'], $additional);
        }

        return $this->respond($response);
    }

    /**
     * @return JsonResponse
     */
    public function respondNotFound(string $message = 'Not Found'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    /**
     * @return JsonResponse
     */
    public function respondInternalError(string $message = 'Internal Server Error'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message);
    }

    /**
     * @param null $data
     *
     * @return JsonResponse
     */
    public function respondCreated(?string $message = 'Created Successfully', $data = null): JsonResponse
    {
        $response = ['message' => $message];

        if ($data) {
            $response['data'] = $data;
        }

        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respond($response);
    }

    /**
     * @return JsonResponse
     */
    public function respondUpdated(string $message = 'Updated Successfully'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond([
                'message' => $message,
            ]);
    }

    /**
     * @return JsonResponse
     */
    public function respondDeleted(string $message = 'Deleted'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond([
                'message' => $message,
            ]);
    }

    /**
     * @param $data
     * @param $paginator
     *
     * @return JsonResponse
     */
    public function respondWithPaginator($data, $paginator): JsonResponse
    {
        $data = array_merge($data, [
            'paginator' => [
                'page' => $paginator->currentPage(),
                'limit' => $paginator->perPage(),
                'total' => $paginator->total(),
                'more' => $paginator->hasMorePages(),
            ],
        ]);

        return $this->respond($data);
    }

    /**
     * @return JsonResponse
     */
    public function respondWithToken(array $token, array $data = []): JsonResponse
    {
        return $this->respond([
            ...$token,
            ...$data,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function respondUnauthenticated(string $message = 'Unauthenticated'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)
            ->respond([
                'message' => $message,
                'code' => 'UNAUTHENTICATED',
            ]);
    }

    /**
     * @return JsonResponse
     */
    public function respondUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)
            ->respond([
                'message' => $message,
                'code' => 'UNAUTHORIZED',
            ]);
    }

    /**
     * @param $messages
     *
     * @return JsonResponse
     */
    public function respondWithInvalidParameters($messages): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
            ->respondWithError('Please make sure you have entered the data correctly', [
                'messages' => $messages,
            ]);
    }


    /**
     * @param $message
     * @param $additional
     *
     * @return JsonResponse
     */
    public function respondWithCode($message, $code, $additional = null): JsonResponse
    {
        $response = [
            'errors' => [
                $message,
            ],
        ];

        if ($additional) {
            $response['data'] = $additional;
        }

        return $this->setStatusCode($code)->respond($response);
    }
}
