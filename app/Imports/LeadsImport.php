<?php

namespace App\Imports;

use App\Models\Leads;
use App\Models\Package_uses;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;


class LeadsImport implements ToModel, WithHeadingRow
{

    use Importable;
    
    private $rows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        ++$this->rows;

        return new Leads([
            'user_id'  => $row['user_id'],
            'lead_name' => $row['lead_name'],
            'lead_last_name' => $row['lead_last_name'],
            'lead_email' => $row['lead_email'],
            // 'lead_description' => $row['lead_description'],
            // 'lead_company_name' => $row['lead_company_name'],
            'lead_number' => $row['lead_number'],
            // 'lead_notes' => $row['lead_notes'],
            // 'lead_status' => $row['lead_status'],
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
