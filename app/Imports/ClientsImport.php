<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ClientsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private $rows = 0;
    private $rowsSuccess = 0;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        HeadingRowFormatter::default('none');

        ++$this->rowsSuccess;

        return new Client([
            'establecimiento' => trim($row['establecimiento']),
            'nombre' => trim($row['nombre']),
            'cedula' => trim($row['cedula']),
            'celular' => trim($row['celular'])
        ]);
    }

    public function headingRow(): int
    {
        return 4;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        ++$this->rows;

        return [
            'establecimiento' => 'required',
            'celular' => 'required|numeric|unique:clients,celular',
            'nombre' => 'required',
        ];
    }


    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getRowCountSuccess(): int
    {
        return $this->rowsSuccess;
    }
}
