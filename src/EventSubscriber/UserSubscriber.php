<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserSubscriber
 *
 * @package App\EventSubscriber
 */
class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    private $encoder;

    /**
     * UserSubscriber constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return mixed[] The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE],
        ];
    }

    /**
     * @param $event
     */
    public function encodePassword(ViewEvent $event)
    {
        /** @var User $user */
        $user = $event->getControllerResult();
        /** @var string $method */
        $method = $event->getRequest()->getMethod();

        if ($user instanceof User && $method === "POST") {
            /** @var string $hash */
            $hash = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
        }
    }
}
