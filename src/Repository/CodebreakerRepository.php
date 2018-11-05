<?php

namespace App\Repository;

use App\Codebreaker\Code;
use App\Codebreaker\GameStats;
use App\Entity\Codebreaker;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CodebreakerRepository extends ServiceEntityRepository
{
    private const PAGE_SIZE = 4;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Codebreaker::class);
        $this->paginator = $paginator;
    }

    public function new(Player $player = null): Codebreaker
    {
        $codebreaker = new Codebreaker(Code::random(), $player);

        $this->save($codebreaker);

        return $codebreaker;
    }

    public function save(Codebreaker $codebreaker)
    {
        if (null !== $codebreaker->player()) {
            $this->getEntityManager()->persist($codebreaker);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Codebreaker[]
     */
    public function continuableGames(Player $player): array
    {
        return $this->createQueryBuilder('c')
            ->select('c, a')
            ->leftJoin('c.attemptedGuesses', 'a')
            ->andWhere('c.attempts < :tries AND c.found = FALSE AND c.player = :player')
            ->setParameter('tries', Codebreaker::TRIES)
            ->setParameter('player', $player)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Codebreaker[]|AbstractPagination
     */
    public function finishedGames(Player $player, int $page = 1): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('c')
                ->andWhere('c.attempts = :tries OR c.found = TRUE')
                ->andWhere('c.player = :player')
                ->setParameter('tries', Codebreaker::TRIES)
                ->setParameter('player', $player),
            $page,
            self::PAGE_SIZE
        );
    }

    public function stats(): GameStats
    {
        $stats = $this->createQueryBuilder('c')
            ->select('AVG(c.attempts) AS average, MIN(c.attempts) as minimum, COUNT(c) AS played')
            ->where('c.found = true OR c.attempts = :tries')
            ->setParameter('tries', Codebreaker::TRIES)
            ->getQuery()
            ->getSingleResult();

        $lost = $this->getEntityManager()
            ->createQuery('SELECT COUNT(c) FROM App\Entity\Codebreaker AS c WHERE c.found = false AND c.attempts = :tries')
            ->setParameter(':tries', Codebreaker::TRIES)
            ->getSingleScalarResult();

        $total = $this->getEntityManager()
            ->createQuery('SELECT COUNT(c) FROM App\Entity\Codebreaker AS c')
            ->getSingleScalarResult();

        return new GameStats(
            $stats['average'],
            $stats['minimum'],
            $stats['played'] - $lost,
            $lost,
            $stats['played'],
            $total - $stats['played'],
            $total
        );
    }
}
