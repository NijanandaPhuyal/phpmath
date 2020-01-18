<?php
    function statementParse($line){
        require_once('nsfRPN.php');
        $rpn = new nsfRPN();
        $ifpos = strpos($line, "if");
        $thenpos = strpos($line, "then");
        $elsepos = strpos($line, "else");
    
        if ( $ifpos === false or $thenpos === false ) {

            $res = $rpn->rpn($line);
            if ($res === false)
                return $line;
            return $res;
        }
        else {
    
            $thenValue = "";
            $elseValue = "";
    
            $ifstate = substr($line, $ifpos + 2, $thenpos - $ifpos - 2);
            $braStart = strpos($ifstate, "(");
            $braEnd = strpos($ifstate, ")");
    
            if ( $elsepos === false ){
                $thenValue = substr($line, $thenpos + 4);
            } else {
                $thenValue = substr($line, $thenpos + 4, $elsepos - $thenpos - 4);
                $elseValue = substr($line, $elsepos + 4);
            }
            
            $ifstate = substr($ifstate, $braStart + 1, $braEnd - $braStart - 1);
            $opPos = -1;
            $ifRes = -1;
    
            if ( ($opPos = strpos($ifstate, ">=")) !== false ) {
                $op1 = (int)substr($ifstate, 0, $opPos);
                $op2 = (int)substr($ifstate, $opPos + 2 );
                if ( $op1 >= $op2 ) { $ifRes = true; } else { $ifRes = false; }
            } else if ( ($opPos = strpos($ifstate, "<=")) !== false ) {
                $op1 = (int)substr($ifstate, 0, $opPos);
                $op2 = (int)substr($ifstate, $opPos + 2 );
                if ( $op1 <= $op2 ) { $ifRes = true; } else { $ifRes = false; }            
            } else if ( ($opPos = strpos($ifstate, "==")) !== false ) {
                $op1 = (int)substr($ifstate, 0, $opPos);
                $op2 = (int)substr($ifstate, $opPos + 2 );
                if ( $op1 == $op2 ) { $ifRes = true; } else { $ifRes = false; }
            } else if ( ($opPos = strpos($ifstate, ">")) !== false ) {
                $op1 = (int)substr($ifstate, 0, $opPos);
                $op2 = (int)substr($ifstate, $opPos + 2 );
                if ( $op1 > $op2 ) { $ifRes = true; } else { $ifRes = false; }
            } else if ( ($opPos = strpos($ifstate, "<")) !== false  ) {
                $op1 = (int)substr($ifstate, 0, $opPos);
                $op2 = (int)substr($ifstate, $opPos + 2 );
                if ( $op1 < $op2 ) { $ifRes = true; } else { $ifRes = false; }
            } else {
                print("Can't find operator");
            }
    
            if ( $ifRes === true ) {
                return statementParse($thenValue);
            } else if ($ifRes === false) {
                return statementParse($elseValue);
            }
        }
    }
    function calc($line){

        if( $line == "" )
            return 'No text';
        $res = statementParse($line);
        return $res;
    }
?>