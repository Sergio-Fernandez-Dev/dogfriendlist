<?php declare(strict_types = 1);

namespace App\Core\Interfaces;

interface EntityInterface
{
    public function getId(): int;
    public function setId(int $id): void;
    public function getClassParams(): array;
    public function setClassParams(array $data, bool $override): void;
}

?>