<?php


namespace Chat\server;


interface Observer
{
    public function onChanged($value);
}