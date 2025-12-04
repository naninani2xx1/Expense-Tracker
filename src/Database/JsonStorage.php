<?php 

namespace App\Database;

class JsonStorage {
    private $pathStorage = __DIR__ . '/../../storage/expenses.json';
    private $pathStorageIdGenerate = __DIR__ . '/../../storage/id_generator.json';

    public function getPathStorage(): string {
        return $this->pathStorage;
    }
    
    public function save(array $data)
    {
        file_put_contents($this->pathStorage, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function getData()
    {
        if (!file_exists($this->pathStorage)) {
            return [];
        }

        $json = file_get_contents($this->pathStorage);
        return json_decode($json, true) ?? [];
    }

    public function generatedId()
    {
        $json = file_get_contents($this->pathStorageIdGenerate);
        $data = json_decode($json, true) ?? [];

        $generatedId = empty($data) ? 1 : $data['lastNumber'] + 1;

        //save into file
        file_put_contents($this->pathStorageIdGenerate, json_encode(['lastNumber' => $generatedId], JSON_PRETTY_PRINT));
        return $generatedId;
    }
}