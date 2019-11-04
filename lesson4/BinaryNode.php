<?php

class BinaryNode {
    private $value;
    private $left;
    private $right;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function setLeft($left) {
        $this->left = $left;
    }

    public function setRight($right) {
        $this->right = $right;
    }

    public function getValue() {
        return $this->value;
    }

    public function getLeft() {
        return $this->left;
    }

    public function getRight() {
        return $this->right;
    }
}

class BinaryTree {
    private $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function getRoot() {
        return $this->root;
    }
}