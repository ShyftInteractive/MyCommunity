<?php declare(strict_types=1);

namespace App\Domain;

use League\Pipeline\Pipeline;

class DomainServices {

    private $pipeline;

    public function __construct()
    {
        $this->pipeline = new Pipeline();
    }

    public function call(callable $stage)
    {
        return (new Pipeline())->pipe($stage)->process([]);
    }

    public function pipeline($pipeline): self
    {
        $this->pipeline = $pipeline;

        return $this;
    }

    public function send($data)
    {
        return $this->pipeline->process(collect($data));
    }
}
