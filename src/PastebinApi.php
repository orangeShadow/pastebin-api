<?php
declare(strict_types = 1);

namespace OrangeShadow\PastebinApi;

use OrangeShadow\PastebinApi\Exceptions;
use OrangeShadow\PastebinApi\Repositories\PastebinRepository;

class PastebinApi
{

    private $responseChecking;
    private $repository;

    /**
     * PastebinApi constructor.
     *
     * @param $api_dev_key
     *
     */
    public function __construct(string $api_dev_key)
    {
        $this->responseChecking = new ResponseChecking();
        $this->repository  = new PastebinRepository($api_dev_key);
    }

    /**
     * Create a new paste
     *
     * @param string $api_past_code
     * @param string $api_paste_name
     * @param string $api_past_format
     * @param string $api_user_key
     * @param string $api_paste_expire_date
     * @param int $api_paste_private
     *
     * @return string
     *
     * @throws Exceptions\BadApiRequestException
     * @throws Exceptions\EmptyPasteCodeException
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\WrongEncodingException
     */
    public function createPaste(string $api_past_code,
                                string $api_paste_name = '',
                                string $api_user_key = '',
                                string $api_past_format = "php",
                                string $api_paste_expire_date = "10M",
                                int $api_paste_private = 1): string
    {

        if (empty($api_past_code)) {
            throw new Exceptions\EmptyPasteCodeException();
        }

        if (!mb_detect_encoding($api_past_code, 'UTF-8', true)) {
            throw new Exceptions\WrongEncodingException();
        }


        $attributes = [
            'api_user_key'          => $api_user_key,
            'api_paste_private'     => $api_paste_private,
            'api_paste_name'        => $api_paste_name,
            'api_paste_expire_date' => $api_paste_expire_date,
            'api_paste_format'      => $api_past_format,
            'api_paste_code'        => $api_past_code
        ];

        $content = $this->repository->createPaste($attributes);

        if ($this->responseChecking->isBadRequest($content)) {
            throw new Exceptions\BadApiRequestException($content);
        }

        return $content;
    }

    /**
     * Listing Pastes Created By A User
     *
     * @param string $api_user_key
     * @param int $api_results_limit
     *
     * @return array
     *
     * @throws Exceptions\BadApiRequestException
     * @throws Exceptions\EmptyUserKeyException
     * @throws Exceptions\InvalidResponseException
     */
    public function getPasteList(string $api_user_key, int $api_results_limit = 50): array
    {
        if (empty($api_user_key)) {
            throw new Exceptions\EmptyUserKeyException();
        }

        $attributes = [
            'api_user_key'      => $api_user_key,
            'api_results_limit' => $api_results_limit,
        ];

        $content = $this->repository->getPasteList($attributes);

        if ($this->responseChecking->isBadRequest($content)) {
            throw new Exceptions\BadApiRequestException($content);
        }

        if ($this->responseChecking->isNotFound($content)) {
            return [];
        }

        return Paste::generatePasteListFromXml($content);
    }

    /**
     * Deleting A Paste Created By A User
     *
     * @param string $api_user_key
     * @param string $api_paste_key
     * @return bool
     * @throws Exceptions\BadApiRequestException
     * @throws Exceptions\EmptyPasteKeyException
     * @throws Exceptions\EmptyUserKeyException
     */
    public function deletePaste(string $api_user_key, string $api_paste_key): bool
    {
        if (empty($api_user_key)) {
            throw new Exceptions\EmptyUserKeyException();
        }

        if (empty($api_paste_key)) {
            throw new Exceptions\EmptyPasteKeyException();
        }

        $attributes = [
            'api_user_key'  => $api_user_key,
            'api_paste_key' => $api_paste_key,
        ];

        $content = $this->repository->deletePaste($attributes);

        if ($this->responseChecking->isBadRequest($content)) {
            throw new Exceptions\BadApiRequestException($content);
        }

        return $this->responseChecking->isPasteRemove($content);
    }

    /**
     * Getting raw paste output of users pastes including 'private' pastes
     *
     * @param string $api_user_key
     * @param string $api_paste_key
     *
     * @return string
     *
     * @throws Exceptions\BadApiRequestException
     * @throws Exceptions\EmptyPasteKeyException
     * @throws Exceptions\EmptyUserKeyException
     * @throws Exceptions\InvalidResponseException
     */
    public function getPastesRaw(string $api_user_key, string $api_paste_key): string
    {
        if (empty($api_user_key)) {
            throw new Exceptions\EmptyUserKeyException();
        }

        if (empty($api_paste_key)) {
            throw new Exceptions\EmptyPasteKeyException();
        }

        $attributes = [
            'api_user_key'  => $api_user_key,
            'api_paste_key' => $api_paste_key,
        ];

        $content = $this->repository->getPasteRaw($attributes);

        if ($this->responseChecking->isBadRequest($content)) {
            throw new Exceptions\BadApiRequestException($content);
        }

        return $content;
    }

}