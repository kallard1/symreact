<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invoice;
use App\Entity\User;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

/**
 * Class InvoiceSubscriber
 *
 * @package App\EventSubscriber
 */
class InvoiceSubscriber implements EventSubscriberInterface
{
    /** @var Security $security */
    private $security;

    /**
     * InvoiceSubscriber constructor.
     *
     * @param Security $security
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
            KernelEvents::VIEW => [
                ['setCount', EventPriorities::PRE_VALIDATE],
                ['setUser', EventPriorities::PRE_VALIDATE],
                ['setCreatedAt', EventPriorities::PRE_VALIDATE],
                ['setUpdatedAt', EventPriorities::PRE_VALIDATE],
            ],
        ];
    }

    /**
     * Increment invoice number.
     *
     * @param ViewEvent $event
     */
    public function setCount(ViewEvent $event)
    {
        /** @var Invoice $invoice */
        $invoice = $event->getControllerResult();
        /** @var string $method */
        $method = $event->getRequest()->getMethod();
        /** @var User $user */
        $user = $this->security->getUser();

        if ($invoice instanceof Invoice && $method === 'POST') {
            /** @var integer $count */
            $count = $user->getInvoiceCounter() + 1;
            /** @var string $invoiceNumber */
            $invoiceNumber = str_pad((string) $count, 5, '0', STR_PAD_LEFT);

            $invoice->setCount('I' . $invoiceNumber);
            $user->setInvoiceCounter($count);
        }
    }

    /**
     * Set user invoice
     *
     * @param ViewEvent $event
     */
    public function setUser(ViewEvent $event)
    {
        /** @var Invoice $invoice */
        $invoice = $event->getControllerResult();
        /** @var string $method */
        $method = $event->getRequest()->getMethod();
        /** @var User $user */
        $user = $this->security->getUser();

        if ($invoice instanceof Invoice && $method === 'POST') {
            $invoice->setUser($user);
        }
    }

    /**
     * @param ViewEvent $event
     *
     * @throws \Exception
     */
    public function setCreatedAt(ViewEvent $event)
    {
        /** @var Invoice $invoice */
        $invoice = $event->getControllerResult();
        /** @var string $method */
        $method = $event->getRequest()->getMethod();

        if ($invoice instanceof Invoice && $method === 'POST') {
            $invoice->setCreatedAt(new DateTime());
        }
    }

    /**
     * @param ViewEvent $event
     *
     * @throws \Exception
     */
    public function setUpdatedAt(ViewEvent $event)
    {
        /** @var Invoice $invoice */
        $invoice = $event->getControllerResult();
        /** @var string $method */
        $method = $event->getRequest()->getMethod();

        if ($invoice instanceof Invoice && $method === 'POST') {
            $invoice->setUpdatedAt(new DateTime());
        }
    }
}
