<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CodebreakerRepository")
 */
class Codebreaker extends \PcComponentes\Codebreaker\Codebreaker
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="codebreaker_code")
     */
    protected $secret;

    /**
     * @ORM\Column(type="integer")
     */
    protected $attempts = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $found = false;
}
