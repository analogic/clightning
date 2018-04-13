<?php

namespace CLightning;

abstract class InOutLogger
{
    abstract function in(?string $in);
    abstract function out(?string $out);
}