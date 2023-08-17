<?php

declare(strict_types=1);

class ReCaptcha
{
    public const SITEKEY = '6LegxsIlAAAAAKJ8FEMekW_9-wIlNh4J0TDEGKyh';
    private const SECRETKEY = '6LegxsIlAAAAACCnAkTUO-4sZhs6R4YtMGatbql8';
    private const BASEURL = 'https://www.google.com/recaptcha/api/siteverify';
    private array $request;
    private array $serverInfo;

    public function __construct(array $request, array $serverInfo)
    {
        $this->serverInfo = $serverInfo;
        $this->request = $request;
    }

    private function getResponseKey(): string
    {
        return $this->request['g-recaptcha-response'];
    }

    private function getUserIp(): string
    {
        return $this->serverInfo['REMOTE_ADDR'];
    }

    private function getUrl(): string
    {
        return self::BASEURL . "?secret=". self::SECRETKEY ."&response=". $this->getResponseKey() ."&remoteip=". $this->getUserIp();
    }

    public function checkReCaptcha(): bool
    {
        try {

            $responseRecaptcha = file_get_contents($this->getUrl());
            $responseRecaptcha = json_decode($responseRecaptcha, false, 512, JSON_THROW_ON_ERROR);

            return $responseRecaptcha->success;
        } catch (Exception) {
            return false;
        }
    }

    public static function getSiteKey(): string
    {
        return self::SITEKEY;
    }
}
