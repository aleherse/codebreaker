<?php

namespace PcComponentes\Codebreaker;

interface CodebreakerRepository
{
    public function new(): Codebreaker;

    public function save(Codebreaker $codebreaker);

    public function continuableGames();

    public function finishedGames(int $page = 1);

    public function stats(): GameStats;
}
