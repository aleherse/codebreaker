<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PcComponentes\Codebreaker\Code;
use PcComponentes\Codebreaker\Codebreaker;
use PcComponentes\Codebreaker\CodebreakerRepository;
use PcComponentes\Codebreaker\GameStats;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineCodebreakerRepository extends ServiceEntityRepository implements CodebreakerRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Codebreaker::class);
    }

    public function new(): Codebreaker
    {
        $codebreaker = new Codebreaker(Code::random());

        $this->save($codebreaker);

        return $codebreaker;
    }

    public function save(Codebreaker $codebreaker)
    {
        $this->getEntityManager()->persist($codebreaker);
        $this->getEntityManager()->flush();
    }

    /**
     * @return Codebreaker[]
     */
    public function continuableGames(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c, a')
            ->leftJoin('c.attemptedGuesses', 'a')
            ->andWhere('c.attempts < :tries AND c.found = FALSE')
            ->setParameter('tries', Codebreaker::TRIES)
            ->getQuery()
            ->getResult();
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
            ->createQuery('SELECT COUNT(c) FROM PcComponentes\Codebreaker\Codebreaker AS c WHERE c.found = false AND c.attempts = :tries')
            ->setParameter(':tries', Codebreaker::TRIES)
            ->getSingleScalarResult();

        $total = $this->getEntityManager()
            ->createQuery('SELECT COUNT(c) FROM PcComponentes\Codebreaker\Codebreaker AS c')
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
