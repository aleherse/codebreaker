<?php

namespace PcComponentes\Codebreaker;

interface CodebreakerRepository
{
    public function new(): Codebreaker;

    public function save(Codebreaker $codebreaker);

    public function continuableGames();

    public function stats(): GameStats;
}
