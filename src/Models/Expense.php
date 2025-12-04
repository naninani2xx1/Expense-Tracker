<?php 

namespace App\Models;

class Expense
{
    public int $id;
    public string $description;
    public float $amount;
    public string $date;

    public function __construct(int $id, string $description, float $amount, string $date)
    {
        $this->id = $id;
        $this->description = $description;
        $this->amount = $amount;
        $this->date = $date;
    }

    public static function fromArray(array $data): Expense
    {
        return new Expense(
            $data['id'],
            $data['description'],
            $data['amount'],
            $data['date']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'amount' => $this->amount,
            'date' => $this->date,
        ];
    }
}