<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

/**
 * Class CustomerSubscriber
 *
 * @package App\EventSubscriber
 */
class CustomerSubscriber implements EventSubscriberInterface
{
    /** @var Security $security */
    private $security;

    /**
     * CustomerSubscriber constructor.
     *
     * @param $security
     */
    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return mixed[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setUser', EventPriorities::PRE_VALIDATE],
        ];
    }

    /**
     * Set user into customer.
     *
     * @param ViewEvent $event
     */
    public function setUser(ViewEvent $event)
    {
        /** @var Customer $customer */
        $customer = $event->getControllerResult();
        /** @var string $method */
        $method = $event->getRequest()->getMethod();

        if ($customer instanceof Customer && $method === "POST") {
            /** @var User $user */
            $user = $this->security->getUser();

            $customer->setUser($user);
        }
    }
}
