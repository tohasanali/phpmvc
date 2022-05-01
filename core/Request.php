<?php
namespace Core;

class Request
{
    public function getPath()
    {
        $root = $this->getRoot();
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = str_replace($root, "", $path);
        $position = strpos($path, '?');
        if($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getRoot()
    {
        $root = dirname(__FILE__);
        $root = str_replace("\\","/",$root);
        $root = str_replace($_SERVER['DOCUMENT_ROOT'],"",$root);
        $root = str_replace("/core","",$root);
        $root = $root . '/public';
        return $root;
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody()
    {
        $body = [];

        if($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}