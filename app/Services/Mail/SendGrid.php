<?php
namespace App\Services\Mail;
use App\Services\Config;
use SendGrid\Mail as Mail;
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
        $mail = new Mail($this->sender, $subject, $to, $text);
        $mail->addAttachment($file);
        $this->sg->client->mail()->send()->post($mail);
    }
}
