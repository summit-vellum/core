<?php
namespace Core;

interface Dashboard {
    
    public function headerColumns($headers = []);

    public function dataRows($rows = []);
}