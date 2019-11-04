<?php

class Token
{
    private $name;
    private $type;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}

class ExpressionTokens
{
    private $expression;
    private $tokens = null;
    private $delimiters = ["(", ")", "/", "*", "+", "-", "^", "&", "|", "%", " "];

    public function __construct(String $expression)
    {
        $this->expression = str_split($expression);
    }

    public function getTokens()
    {
        if ($this->tokens === null) {
            $this->createTokensFromExpression();
        }
        return $this->tokens;
    }

    private function createTokensFromExpression()
    {
        $this->tokens = [];
        $this->createTokens();
        $this->correctionTokensType();
    }

    private function createTokens()
    {
        $i = 0;
        while ($i < count($this->expression)) {
            $name = "";
            if (in_array($this->expression[$i], $this->delimiters)) {
                if ($this->expression[$i] === ' ') {
                    $i++;
                } else {
                    $name = $this->expression[$i];
                    $i++;
                    $this->tokens[] = new Token($name, 'op');
                }
            } else {
                while (!in_array($this->expression[$i], $this->delimiters)) {
                    $name .= $this->expression[$i];
                    $i++;
                }
                $this->tokens[] = new Token($name, 'var');
            }
        }
    }

    private function correctionTokensType()
    {
        for ($j = 0; $j < count($this->tokens); $j++) {
            if ($this->tokens[$j]->getName() === '(') {
                $this->tokens[$j]->setType('op_br');
            } else if ($this->tokens[$j]->getName() === ')') {
                $this->tokens[$j]->setType('cl_br');
            } else if (is_numeric($this->tokens[$j]->getName())) {
                $this->tokens[$j]->setType('num');
            }
        }
    }
}
