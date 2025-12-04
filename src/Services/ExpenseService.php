<?php

namespace App\Services;

use App\Models\Expense;
use App\Utils\StringUtils;

class ExpenseService 
{
    private $databaseConn;

    public function __construct($databaseConn)
    {
        $this->databaseConn = $databaseConn;
    }

    public function add($des, $amount)
    {
        $data = $this->databaseConn->getData();
        $date = date('Y-m-d');
        $newId = $this->databaseConn->generatedId();
        $newExpense = [
            'id' => $newId,
            'description' => $des,
            'amount' => $amount,
            'date' => $date
        ];

        $data[] = $newExpense;

        $this->databaseConn->save($data);


        echo "Expense added successfully with ID: {$newId}\n";
    }

    public function showList()
    {
        $data = $this->databaseConn->getData();

        if (empty($data)) {
            echo "No expenses found.\n";
            return;
        }

        foreach ($data as $expense) {
            $expenseObj = Expense::fromArray($expense);
            echo "ID\tDate\t\tDescription\tAmount\n";
            echo "{$expenseObj->id}\t{$expenseObj->date}\t {$expenseObj->description}\t\t {$expenseObj->amount}\n";
        }   
    }

    public function summary($month = null)
    {
        $data = $this->databaseConn->getData();

        if (empty($data)) {
            echo "No expenses found.\n";
            return;
        }
        if(is_null($month)) {
            $total = array_sum(array_column($data, 'amount'));
            echo "Total Expenses: {$total}$\n";
            exit(1);
        }
        
        $data =  array_reduce($data, function ($carry, $item) use ($month) {
            $itemMonth = date('m', strtotime($item['date']));
            if ($itemMonth == $month) {
                $carry += $item['amount'];
            }
            return $carry;
        }, 0);

        echo "Total Expenses for ".StringUtils::monthNumberToName($month).": {$data}$\n";
    }

    public function delete($id)
    {
        $data = $this->databaseConn->getData();

        if (empty($data)) {
            echo "No expenses found.\n";
            return;
        }
        
        $index = array_search($id, array_column($data, 'id'));
        if ($index === false) {
            echo "Expense with ID: {$id} not found.\n";
            return;
        }
        
        // Remove the last expense
        unset($data[$index]);
        $this->databaseConn->save($data);

        echo "Expense deleted successfully.\n";
    }

    public function exportCSV()
    {
        $data = $this->databaseConn->getData();
        $filename = __DIR__ .'/../../data/expenses_export_' . date('Ymd_His') . '.csv';

        if (empty($data)) {
            echo "No expenses found.\n";
            return;
        }
        $file = fopen($filename, 'w');

        // Add CSV headers
        fputcsv($file, ['ID', 'Description', 'Amount', 'Date']);

        // Add data rows
        foreach ($data as $expense) {
            fputcsv($file, [$expense['id'], $expense['description'], $expense['amount'], $expense['date']]);
        }

        fclose($file);

        echo "Expenses exported successfully in folder data}\n";
    }
}