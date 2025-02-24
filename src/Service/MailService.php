<?php

namespace App\Service;

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
    }
}