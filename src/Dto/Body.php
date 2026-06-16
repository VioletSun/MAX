<?php

namespace VioletSun\MAX\Dto;

class Body extends BaseObject
{
    protected static array $schema = [];
    public function mid(): ?string { return $this->getString('mid'); }
    public function seq(): ?int { return $this->getInt('seq'); }
    public function text(): ?string { return $this->getString('text'); }
}
