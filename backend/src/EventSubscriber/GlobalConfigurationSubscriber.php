<?php

namespace App\EventSubscriber;

use App\Services\Redis\RedisServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;


class GlobalConfigurationSubscriber implements EventSubscriberInterface
{
    public const TOKEN_BLACKLIST = 'tokenBlacklist';

    /** @var RedisServiceInterface */
    private RedisServiceInterface $redisService;

    /** @var bool $isTokenChecked */
    private bool $isTokenChecked = false;

    public function __construct(RedisServiceInterface $redisService)
    {
        $this->redisService = $redisService;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['validateToken'],
                ['modifyRequestContent']
            ],
        ];
    }

    /**
     * @param ControllerEvent $event
     */
    public function validateToken(ControllerEvent $event): void
    {
        $token = $event->getRequest()->headers->get('authorization');

        if (!$event->getRequest()->attributes->get('_route') === 'logout' && !$this->isTokenChecked) {
            $this->isTokenChecked = true;

            if ($this->isBlacklistToken($token)) {
                throw new AccessDeniedHttpException('Your Token is invalid');
            }
        }

        if ($event->getRequest()->attributes->get('_route') === 'logout') {
            if (!$this->isBlacklistToken($token)) {
                $this->redisService->pushToList(self::TOKEN_BLACKLIST, $token);
            }
        }
    }

    /**
     * @param string $token
     * @return bool
     */
    private function isBlacklistToken(string $token): bool
    {
        if (!$this->redisService->exists(self::TOKEN_BLACKLIST)) {
            return false;
        }

        return in_array($token, $this->getTokenBlacklist());
    }

    /**
     * @return array
     */
    private function getTokenBlacklist(): array
    {
        return $this->redisService->getCompleteList(self::TOKEN_BLACKLIST);
    }

    /**
     * @param ControllerEvent $event
     */
    public function modifyRequestContent(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }
    }
}
