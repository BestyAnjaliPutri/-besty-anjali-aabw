<?php

namespace CodeIgniter;

if (defined('SYSTEMPATH') && file_exists(SYSTEMPATH . 'Entity/Entity.php')) {
    require_once SYSTEMPATH . 'Entity/Entity.php';
} elseif (file_exists(__DIR__ . '/../../vendor/codeigniter4/framework/system/Entity/Entity.php')) {
    require_once __DIR__ . '/../../vendor/codeigniter4/framework/system/Entity/Entity.php';
}

if (! class_exists('CodeIgniter\Entity', false) && class_exists('CodeIgniter\Entity\Entity', false)) {
    class_alias('CodeIgniter\Entity\Entity', 'CodeIgniter\Entity');
}
