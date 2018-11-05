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

        $this->cache->set(self::CACHE_KEY, $player->generateNewSession(), self::CACHE_EXPIRATION_TIME);
        $this->players->save($player);

        return true;
    }

    public function currentPlayer(): ?Player
    {
        $session = $this->cache->get(self::CACHE_KEY);
        if (null === $session) {
            return null;
        }

        return $this->players->createQueryBuilder('p')
            ->where('p.session = :session')
            ->setParameter('session', $session)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
