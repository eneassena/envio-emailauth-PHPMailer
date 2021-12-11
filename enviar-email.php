<?php 

require __DIR__.'/vendor/autoload.php';

use App\Controller\Comunication\Email;


$address        = ['destinatario@gmail.com'];
$subject        = 'Teste email kkk';
$body           = '<p>Iai mano usei seu email para testar envio de email com php kk falow :-)</p>';

$obMailer       = new Email;
$success        = $obMailer->sendEmail($address, $subject, $body);

echo $success ? 'Mensagem enviada com sucesso!' : $obMailer->getError();