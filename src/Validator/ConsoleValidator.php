<?php 

namespace App\Validator;

class ConsoleValidator
{
    public static function validateAdd(int $argc,array $args): bool
    {
        if($argc < 6) {
            echo "Usage: expense-tracker <command> --description [value] --amount [value] \n";
            echo "- Commands:\n";
            echo "  * add, delete, update \n";
            return false;
        }
        // index: 1 to description, index: 3 to amount
        $requiredArguments = [1 => constant('description'), 3 => constant('amount')];
        foreach ($requiredArguments as $index => $argName) {
            if (!isset($args[$index]) || $args[$index] !== $argName) {
                echo "Error: Missing or incorrect argument '$argName'.\n";
                return false;
            }
        }


        return true;
    }

    public static function validateSummary(int $argc,array $args): bool
    {
        if($argc == 2)
            return true;
        
        if($argc < 4) {
            echo "Usage: expense-tracker sumary --month [value] \n";
            return false;
        }
        // index: 1 to description, index: 3 to amount
        $requiredArguments = [1 => constant('month')];
        foreach ($requiredArguments as $index => $argName) {
            if (!isset($args[$index]) || $args[$index] !== $argName) {
                echo "Error: Missing or incorrect argument '$argName'.\n";
                return false;
            }
        }


        return true;
    }
}