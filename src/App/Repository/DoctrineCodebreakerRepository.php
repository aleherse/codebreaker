<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PcComponentes\Codebreaker\Code;
use PcComponentes\Codebreaker\Codebreaker;
use PcComponentes\Codebreaker\CodebreakerRepository;
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
        $this->_em->persist($codebreaker);
        $this->_em->flush();
    }

    /**
     * Codebreaker[]
     */
    public function continuableGames(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.attempts < :tries AND c.found = FALSE')
            ->setParameter('tries', Codebreaker::TRIES)
            ->getQuery()
            ->getResult();
    }
}
