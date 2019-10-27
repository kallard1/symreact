<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JwtCreatedSubscriber
 *
 * @package App\EventSubscriber
 */
class JwtCreatedSubscriber
{
    /**
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        /** @var mixed[] $payload */
        $payload = $event->getData();

        $payload['firstName'] = $user->getFirstName();
        $payload['lastName']  = $user->getLastName();

        $event->setData($payload);
    }
}
