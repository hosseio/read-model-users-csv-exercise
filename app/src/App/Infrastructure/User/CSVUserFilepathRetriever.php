<?php

namespace App\Infrastructure\User;

use Symfony\Component\HttpKernel\KernelInterface;

class CSVUserFilepathRetriever
{
    /** @var string */
    private $file;

    public function __construct(KernelInterface $appKernel, string $usersFilepath)
    {
        $this->appKernel = $appKernel;
        $this->file = $appKernel->getProjectDir().'/../'.$usersFilepath;
    }

    public function get(): string
    {
        return $this->file;
    }
}
