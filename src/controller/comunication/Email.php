<?php 

namespace App\Controller\Comunication;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;


class Email {
    /**
     * Credencias de acesso ao SMTP
     * @var string
     */
    const HOST      = 'smtp.gmail.com';
    const USER      = 'email-do-emissor-de-envio';
    const PASS      = 'senha-do-email';
    const SECURE    = 'TLS';
    const PORT      = 587;
    const CHARSET   = 'UTF-8';

    /**
     * Dados do remetente
     * @var string
     */
    const FROM_EMAIL = 'exemple@gmail.com';
    const FROM_NAME = '(first name) (last name)';

    /**
     * error
     * @var string
     */
    private $error;

    /**
     * Método responsavel por retorna a messagem de error
     * @return string
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Método responsavel por enviar email
     * @param string|array $addresses
     * @param string $subject
     * @param string $body
     * @param string|array $attachments
     * @param string|array $ccs
     * @param string|array $bccs
     * @return boolean
     */
    public function sendEmail($addresses, $subject, $body, $attachments = [], $ccs = [], $bccs = []) {
        // LIMPAR A MENSAGEM DE ERRROR
        $this->error = '';

        // INSTANCIA DE PHPMAILER
        $obMailer = new PHPMailer(true);
        try {

            // CRENDENCIAIS DE ACESSO AO SMTP
            $obMailer->isSMTP(true);
            $obMailer->Host = self::HOST;
            $obMailer->SMTPAuth = true;
            $obMailer->Username = self::USER;
            $obMailer->Password = self::PASS;
            $obMailer->SMTPSecure = self::SECURE;
            $obMailer->Port = self::PORT;
            $obMailer->CharSet = self::CHARSET;

            // REMETENTE
            $obMailer->setFrom(self::FROM_EMAIL, self::FROM_NAME);
            
            // DESTINATARIOS
            $addresses = is_array($addresses) ? $addresses : [$addresses];
            foreach($addresses as $address) {
                $obMailer->addAddress($address);
            }

            // ANEXOS
            $attachments = is_array($attachments) ? $attachments : [$attachments];
            foreach($attachments as $attachment) {
                $obMailer->addAttachment($attachment);
            }

            // CC
            $ccs = is_array($ccs) ? $ccs : [$ccs];
            foreach($ccs as $cc) {
                $obMailer->addCC($cc);
            }

            // BCC
            $bccs = is_array($bccs) ? $bccs : [$bccs];
            foreach($bccs as $bcc) {
                $obMailer->addBCC($bcc);
            }

            // CONTEUDO DO EMAIL
            $obMailer->isHTML(true);
            $obMailer->Subject = $subject;
            $obMailer->Body = $body;

            // enviando email
            return $obMailer->send();
        } catch(PHPMailerException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
}
