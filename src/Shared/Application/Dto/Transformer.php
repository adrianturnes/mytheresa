<?php

declare(strict_types=1);

namespace App\Shared\Application\Dto;

interface Transformer
{
    public function transform($data): array;
}
