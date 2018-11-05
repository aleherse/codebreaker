<?php

namespace App\Security;

use App\Repository\PlayerRepository;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Authentication
{
    private const CACHE_EXPIRATION_TIME = 1800;

    /**
     * @var PlayerRepository
     */
    private $players;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(
        PlayerRepository $players,
        UserPasswordEncoderInterface $encoder,
        CacheInterface $cache
    ) {
        $this->players = $players;
        $this->encoder = $encoder;
        $this->cache = $cache;
    }

    public function login(string $username, string $password): bool
    {
        $player = $this->players->findOneBy(['username' => $username]);

        if (null === $player || !$this->encoder->isPasswordValid($player, $password)) {
            return false;
        }

        $this->cache->set('user_session', $player->generateNewSession(), self::CACHE_EXPIRATION_TIME);
        $this->players->save($player);

        return true;
    }
}
