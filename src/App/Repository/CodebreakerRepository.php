<?php

namespace App\Repository;

use App\Entity\Codebreaker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PcComponentes\Codebreaker\Code;
use Symfony\Bridge\Doctrine\RegistryInterface;
use PcComponentes\Codebreaker\Codebreaker as DomainCodebreaker;

class CodebreakerRepository extends ServiceEntityRepository implements \PcComponentes\Codebreaker\CodebreakerRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Codebreaker::class);
    }

    public function new(): DomainCodebreaker
    {
        $codebreaker = new Codebreaker(Code::random());

        $this->save($codebreaker);

        return $codebreaker;
    }

    public function save(DomainCodebreaker $codebreaker)
    {
        $this->_em->persist($codebreaker);
        $this->_em->flush();
    }
}
