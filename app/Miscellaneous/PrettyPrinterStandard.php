<?php

namespace App\Miscellaneous;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\PrettyPrinter\Standard;

class PrettyPrinterStandard extends Standard
{
    public function pExpr_Array(Array_ $node)
    {
        dd($node);
        if (empty($node->items)) {
            return '[]';
        }
        $result = "[";
        foreach ($node->items as $item) {
            /** @var Node $comments */
            $comments = $item->getAttribute('comments', []);
            if ($comments) {
                $result .= "\n" . $this->pComments($comments);
            }
            $result .= "\n" . $this->p($item) . ",";
        }
        return $result . "\n]";
    }
}
