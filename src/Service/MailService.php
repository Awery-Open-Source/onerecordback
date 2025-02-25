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
        $this->message->thread_id = $this->message->id ?? null;
        unset($this->message->id);

        $event = new Event();
        foreach ($this->message as $key => $value) {
            $event->{$key} = $value;
        }
        $this->entityManager->persist($event);
        $this->entityManager->flush();

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

        $event = $this->entityManager->getRepository(Event::class);

        foreach ($fsuMessage->getParsedData() as $key => $value) {
            $event->{$key} = $value;
        }

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        $eventFor = $entity->one_record_url;

        $statusDescr = FSUMessageService::getDescOfStatus($fsuMessage->status);

        $domain = getenv('DOMAIN', 'https://ordub.awery.com.ua/');

        $eventJson = <<<JSON
        {
          "eventCode": "$event->type",
          "eventFor": "$eventFor",
          "eventLocation": "$event->location",
          "eventTimeType": "$fsuMessage->status",
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

    }
}