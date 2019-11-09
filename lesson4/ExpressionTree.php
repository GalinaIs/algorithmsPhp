<?php
require "Tokens.php";
require "BinaryNode.php";

class ExpressionTree
{
    private $expression;
    private $tokens;
    private $operationPriority = ["+" => 10, "-" => 10, "*" => 20, "/" => 20, "^" => 30, "%" => 20, "&" => 5, "|" => 5];
    private $postfix = null;
    private $tree = null;
    private $expressionByTree;

    public function __construct($expression)
    {
        $this->expression = $expression;
        $this->tokens = (new ExpressionTokens($expression))->getTokens();
    }

    public function getPostfix()
    {
        if ($this->postfix === null) {
            $this->createPostfixFromTokens();
        }
        return $this->postfix;
    }

    public function getTree()
    {
        $this->getPostfix();
        if ($this->tree === null) {
            $this->createTreeFromPostfix();
        }
        return $this->tree;
    }

    public function getExpressionByTree()
    {
        $this->getTree();
        if ($this->expressionByTree === null) {
            $this->expressionByTree = $this->createExpressionByTree($this->tree->getRoot());
        }
        return $this->expressionByTree;
    }


    private function createPostfixFromTokens()
    {
        $this->postfix = [];
        $stack = new SplStack();
        for ($i = 0; $i < count($this->tokens); $i++) {
            switch ($this->tokens[$i]->getType()) {
                case "var":
                case "num":
                    $this->postfix[] = $this->tokens[$i];
                    break;
                case "op_br":
                    $stack->push($this->tokens[$i]);
                    break;
                case "cl_br":
                    while ($stack->top()->getType() != "op_br") {
                        $this->postfix[] = $stack->pop();
                    }
                    $stack->pop();
                    break;
                case "op":
                    if ($stack->count() > 0) {
                        while (
                            $stack->count() > 0 && $stack->top()->getType() == "op" &&
                            $this->operationPriority[$this->tokens[$i]->getName()] <= $this->operationPriority[$stack->top()->getName()]
                        ) {
                            $this->postfix[] = $stack->pop();
                        }
                    }
                    $stack->push($this->tokens[$i]);
                    break;
            }
        }

        while ($stack->count() > 0) {
            $this->postfix[] = $stack->pop();
        }
    }

    private function createTreeFromPostfix()
    {
        $stack = new SplStack();
        $nodeStack = new SplStack();
        foreach ($this->postfix as $token) {
            if ($token->getType() != 'op') {
                $stack->push($token);
            } else {
                if ($stack->count() >= 2) {
                    $currentNode = new BinaryNode($token);
                    $currentNode->setLeft(new BinaryNode($stack->pop()));
                    $currentNode->setRight(new BinaryNode($stack->pop()));
                    $nodeStack->push($currentNode);
                } else if ($nodeStack->count() >= 2) {
                    $currentNode = new BinaryNode($token);
                    $currentNode->setLeft($nodeStack->pop());
                    $currentNode->setRight($nodeStack->pop());
                    $nodeStack->push($currentNode);
                } else {
                    $currentNode = new BinaryNode($token);
                    $currentNode->setLeft($nodeStack->pop());
                    $currentNode->setRight(new BinaryNode($stack->pop()));
                    $nodeStack->push($currentNode);
                }
            }
        }
        $this->tree = new BinaryTree($nodeStack->pop());
    }

    private function createExpressionByTree($node)
    {
        if ($node->getValue()->getType() != "op") {
            return $node->getValue()->getName();
        }
        return "(" . $this->createExpressionByTree($node->getLeft()) . $node->getValue()->getName() .
            $this->createExpressionByTree($node->getRight()) . ")";
    }
}

$expressionTree = new ExpressionTree("  (x+10.2)   ^2+5*y-z    ");
//многовато скобок, но собирает выражение эквивалентное получеенному вначале.
var_dump($expressionTree->getExpressionByTree());