<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationsImport implements ToModel, WithHeadingRow, WithCustomCsvSettings, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function model(array $row)
    {

        return new Location([
            'zipcode'               => $row["d_codigo"] ?? null,
            'settlement'            => $this->eliminar_tildes($row["d_asenta"]) ?? null,
            'settlement_type'       => $this->eliminar_tildes($row["d_tipo_asenta"]) ?? null,
            'municipality'          => $this->eliminar_tildes($row["d_mnpio"]) ?? null,
            'state'                 => $this->eliminar_tildes($row["d_estado"]) ?? null,
            'city'                  => $this->eliminar_tildes($row["d_ciudad"]) ?? null,
            'd_cp'                  => $row["d_cp"] ?? null,
            'state_code'            => $this->eliminar_tildes($row["c_estado"]) ?? null,
            'office_code'           => $row["c_oficina"] ?? null,
            'settlement_type_code'  => $row["c_tipo_asenta"] ?? null,
            'municipality_code'     => $this->eliminar_tildes($row["c_mnpio"]) ?? null,
            'settlement_id'         => $row["id_asenta_cpcons"] ?? null,
            'zone'                  => $this->eliminar_tildes($row["d_zona"]),
            'city_code'             => $row["c_cve_ciudad"],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    function eliminar_tildes($cadena){

    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    return utf8_encode($cadena);
    }
}
