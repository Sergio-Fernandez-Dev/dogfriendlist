<?php declare (strict_types = 1);
namespace App\Auth\Mail;

use App\Models\Users\User;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email extends PHPMailer {

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $email_name;

    /**
     * @param bool $exceptions
     */
    public function __construct(bool $exceptions = null) {

        parent::__construct($exceptions);

        $config = require \MAIL_CONFIG;

        $this->host = $config['host'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->address = $config['address'];
        $this->email_name = $config['name'];

        $this->SMTPDebug = SMTP::DEBUG_OFF; //Enable verbose debug output
        $this->SMTPAuth = true; //Enable SMTP authentication
        $this->isSMTP(); //Send using SMTP
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $this->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $this->Host = $this->host; //Set the SMTP server to send through
        $this->Username = $this->username; //SMTP username
        $this->Password = $this->password; //SMTP password

    }

    /**
     * @param User $user
     */
    public function sendVerificationEmail(User $user) {

        $page = \file_get_contents(BASE_VIEW_PATH . 'auth/email/verification-email.html');
        $body = \str_replace('$activation_key', $user->getActivationKey(), $page);
        $body = \str_replace('$username', $user->getUsername(), $body);

        $text = \file_get_contents(BASE_VIEW_PATH . 'auth/email/verification-email.txt');
        $alt_body = \str_replace('$activation_key', $user->getActivationKey(), $text);
        $alt_body = \str_replace('$username', $user->getUsername(), $alt_body);

        try {

            $this->setFrom($this->address, $this->email_name);
            $this->addAddress($user->getEmail());

            $this->isHTML(true); //Set email format to HTML
            $this->Subject = 'Dogfriendlist - Activa tu cuenta';
            $this->Body = $body;
            $this->AltBody = $alt_body;
            $this->CharSet = 'UTF-8';

            $this->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->ErrorInfo}";
        }
    }

}

?>