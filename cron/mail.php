<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controller\GMailController;
use Symfony\Component\HttpFoundation\Request;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$controller = new GMailController();
try {
    $mailsList = array_filter(json_decode(
        $controller->getMails(new Request([]))->getContent(),
        true
    )['data_list']['messages'] ?? [], fn($mail) => strtotime($mail['date']) > (time() - 60));

    foreach ($mailsList as &$email) {
        try {
            $email = json_decode($controller->getMailDetails(['email_id' => $email['id']])->getContent(), true)['data_list']['message'];
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die;
        }
    }
    unset($email);

    //HERE WE CAN DO ANYTHING WITH $mailsList
    //$mailsList[X]['body'] - body of email
    echo json_encode($mailsList);
} catch (\Doctrine\DBAL\Exception|Exception $e) {

}
