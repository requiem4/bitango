<?php

namespace App\Messages;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SmsMessage
{

    protected string $login;
    protected string $api_token;
    protected string $xml_endpoint;
    protected string $sender_name;
    protected string $to;
    protected string $from;
    protected string $message;
    protected string $service_enabled;

    protected array $lines;
    protected string $dryrun = 'no';

    /**
     * SmsMessage constructor.
     * @param array $lines
     */
    public function __construct($lines = [])
    {
        $this->lines = $lines;

        $this->login = config('services.inforu.login');
        $this->api_token = config('services.inforu.api_token');
        $this->xml_endpoint = config('services.inforu.xml_endpoint');
        $this->sender_name = config('services.inforu.sender_name');
        $this->service_enabled = config('services.inforu.service_enabled');
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function sender_name(string $sender_name): self
    {
        $this->sender_name = $sender_name;

        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->lines->join("\n", "");
    }



    public function send(): mixed
    {
        if (!$this->from || !$this->to || !count($this->lines)) {
            throw new \Exception('SMS not correct.');
        }

        return Http::baseUrl($this->xml_endpoint)->withBasicAuth($this->login, $this->api_token)
            ->asForm()
            ->post('sms', [
                'from' => $this->from,
                'to' => $this->to,
                'message' => $this->lines->join("\n", ""),
                'dryryn' => $this->dryrun
            ]);
    }

    public function dryrun($dry = 'yes'): self
    {
        $this->dryrun = $dry;

        return $this;
    }
}
