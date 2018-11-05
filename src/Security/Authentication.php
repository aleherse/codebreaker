<?php

namespace App\Security;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Authentication
{
    private const CACHE_EXPIRATION_TIME = 1800;
    private const CACHE_KEY = 'user_session';

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
        CacheInterface $cache = null
    ) {
        $this->players = $players;
        $this->encoder = $encoder;
        $this->cache = $cache;
    }

    public function player(string $username, string $password): ?Player
    {
        $player = $this->players->findOneBy(['username' => $username]);

        if (null === $player || !$this->encoder->isPasswordValid($player, $password)) {
            return null;
        }

        if (null !== $this->cache) {
            $this->cache->set(self::CACHE_KEY, $player->generateNewSession(), self::CACHE_EXPIRATION_TIME);
            $this->players->save($player);
        }

        return $player;
    }

    public function currentPlayer(): ?Player
    {
        if (null === $this->cache) {
            return null;
        }

        $session = $this->cache->get(self::CACHE_KEY);
        if (null === $session) {
            return null;
        }

        $this->cache->set(self::CACHE_KEY, $session, self::CACHE_EXPIRATION_TIME);

        return $this->players->createQueryBuilder('p')
            ->where('p.session = :session')
            ->setParameter('session', $session)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function logout()
    {
        if (null !== $this->cache) {
            $this->cache->delete(self::CACHE_KEY);
        }
    }
}
