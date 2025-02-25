<?php

namespace App\Service;

use App\Entity\Awb;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class MailService
{
    private EntityManagerInterface $entityManager;

    public \stdClass $message;
    public function __construct(\stdClass $message, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->message = $message;
        $this->storeMessage();
    }

    public function storeMessage()
    {
        $this->message->message_id = $this->message->id ?? null;
        unset($this->message->id);

        $event = new Event();
        foreach ($this->message as $key => $value) {
//            if ($key == 'short') continue;
            if (property_exists($event, $key)) {
                $event->{$key} = $value;
            }
        }
//        $this->entityManager->persist($event);
//        $this->entityManager->flush();

        $fsuMessage = new FSUMessageService($event->body);

        $dateCreate = new \DateTime();
        $dateCreateStr = $dateCreate->format('Y-m-d\TH:i:s.v\Z');

        $dateEvent = \DateTime::createFromFormat('dMHi', $fsuMessage->getParsedData()['dateAction']);
        $dateEventStr = $dateEvent->format('Y-m-d\TH:i:s.v\Z');

        $repository = $this->entityManager->getRepository(Awb::class);

        $entity = $repository->findOneBy(['awb_no' => $fsuMessage->getParsedData()['awb_no']]);

        if (empty($entity)) {
            return;
        }

//        $event = new Event();
//        $event->one_record_id = '';

        foreach ($fsuMessage->getParsedData() as $key => $value) {
            if ($key == 'dateAction') {
                $event->dateAction = $dateEvent;
                continue;
            }
            if (property_exists($event, $key)) {
                $event->{$key} = $value;
            }
        }
        $event->awb_id = $entity->id;
        $event->dateCreate =new \DateTime();
//        var_dump($event);
        $this->entityManager->persist($event);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            var_dump($event->getId());
        }
//        $this->entityManager->persist($event);
//        $this->entityManager->flush();

        $eventFor = $entity->one_record_url;

        $statusDescr = FSUMessageService::getDescOfStatus($fsuMessage->status);

        $domain = getenv('DOMAIN', 'https://ordub.awery.com.ua/');
        $enum = \App\Entity\Cargo\Enum\EventTimeType::ACTUAL;
        $eventJson = <<<JSON
        {
          "eventCode": "$event->type",
          "eventFor": "$eventFor",
          "eventLocation": "$event->location",
          "eventTimeType": "ACTUAL",
          "recordingOrganization": "$domain",
          "creationDate": "$dateCreateStr",
          "eventDate": "$dateEventStr",
          "eventName": "$statusDescr"
        }
        JSON;

        $url = $eventFor."/logistics-events";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$eventJson,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/ld+json',
                'Accept: application/ld+json'
            ),
        ));

        $response = json_decode(curl_exec($curl));

        $headers = $this->getHeaders($response);

        $event->one_record_id = $headers['Location']??null;

        $this->entityManager->flush();

    }

    private function getHeaders($response): array
    {
        $headers = array();
        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
        foreach (explode("\r\n", $header_text) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        }
        return $headers;
    }
}