<?php

namespace Magefix\Fixture;


interface Builder
{
    function invokeProvidersMethods();
    function build();
}
