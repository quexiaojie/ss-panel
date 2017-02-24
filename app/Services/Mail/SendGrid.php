<?php
namespace App\Services\Mail;
use App\Services\Config;
use SendGrid as SendGridService;
class SendGrid extends Base
{
    private $config, $sg, $sender;
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->config = $this->getConfig();
        $this->sg = new SendGridService($this->config["key"]);
        $this->sender = $this->config["sender"];
    }
    /**
     * @codeCoverageIgnore
     */
    public function getConfig()
    {
        return [
            "key" => Config::get('grid_key'),
            "sender" => Config::get('grid_sender')
        ];
    }
    /**
     * @codeCoverageIgnore
     */
    public function send($to, $subject, $text, $file)
    {
        $request_body = [
            "personalizations" => [
             [
                "to" => [
                    ["email" => $to]
                ],
                "subject" => $subject
            ]
            ],
            "from" => [ "email" => $this->sender ],
            "content" => [
                [
                    "type" => "text/plain",
                    "value"=> $text
                ]
            ]
        ];
        @$this->sg->client->mail()->send()->post($request_body);
    }
}
