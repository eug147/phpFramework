<?php


namespace wfm;


abstract class Model
{

    public  $attributes = [];
    public  $errors = [];
    public  $rules = [];
    public  $labels = [];

    public function __construct()
    {
//        Db::getInstance();
    }

}