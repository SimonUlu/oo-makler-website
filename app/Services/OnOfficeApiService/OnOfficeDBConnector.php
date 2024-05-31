<?php

namespace App\Services\OnOfficeApiService;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OnOfficeDBConnector
{
    public function insertIntoDB(mixed $api_call, $table_name, $primaryKey)
    {
        foreach ($api_call as $row) {
            // ## check formatting of input
            // check if array is multidimensional (due to oo input)
            if (isset($row['elements'])) {
                $row = $row['elements'];
            }
            // check if array key contains illegal strings
            foreach (array_keys($row) as $rowKey) {
                // if illegal string is found edit row key
                if (str_contains($rowKey, '.')) {
                    // assign new key that is not illegal
                    $row[explode('.', $rowKey)[0]] = $row[$rowKey];
                    // unset old key that was illegal
                    unset($row[$rowKey]);
                }
            }
            // serialize nested arrays to be able to store them into db
            foreach ($row as $subRowKey => $subRowVal) {
                if (is_array($subRowVal)) {
                    $row[$subRowKey] = serialize($subRowVal);
                }
            }

            // for each entry, insert into DB
            DB::table($table_name)->upsert(
                $row,
                [$primaryKey]
            );
        }
    }

    public function alterDBDynamically($dbModel, $table_name, $fields_input, $timestamps = false)
    {
        $fields = [];
        $rowSize = 0;
        foreach ($fields_input as $key => $val) {
            // transform types if necessary
            if ($val['type'] == 'varchar') {
                $val['type'] = 'text';
            } // do not string as it would end in row size too large exception
            if ($val['type'] == 'date') {
                $val['type'] = 'datetime';
            }
            if ($rowSize > 8000 && $val['type'] == 'string') {
                $val['type'] = 'text';
            }
            // check if column already exists
            //if(in_array($key, Schema::getColumnListing($table_name)))
            //dd(Schema::getColumnListing($table_name));
            if (! Schema::hasColumn($dbModel->getTable(), $key)) {
                $rowSize += $val['length'];
                // fill fields for database
                $fields[] = [
                    'name' => $key,
                    'type' => $val['type'],
                    'size' => $val['length'],
                    'default' => $val['default'],
                    'index' => $val['index'] ?? 0,
                    'nullable' => $val['nullable'] ?? 0,
                    'unsigned' => $val['unsigned'] ?? 0,
                ];
            }
        }

        if (count($fields) > 0) {
            Schema::table($table_name, function (Blueprint $table) use ($fields, $timestamps) {
                $cnt = 0;
                foreach ($fields as $field) {
                    if ($field['size'] > 0) {
                        $table->{$field['type']}($field['name'], $field['size']);
                    } elseif (in_array($field['type'], ['singleselect', 'multiselect', 'user', 'blackhint', 'redhint', 'dividingline'])) {
                        // exceptions for string
                        $table->{'text'}($field['name']);
                        // fields might not have nullable set to true, thus do it manually here because there is no reason for them to be not nullable
                        $field['nullable'] = 0;
                        // fields should not have set default value, however, this might be set due to the data onOffice hands over
                        $field['default'] = null;
                    } elseif ($field['type'] == 'blob') {
                        // exceptions for string
                        $table->{'binary'}($field['name']);
                    } else {
                        $table->{$field['type']}($field['name']);
                    }
                    if ($field['nullable'] > 0) {
                        $table->getColumns()[$cnt]->nullable();
                    }
                    if ($field['unsigned'] > 0) {
                        $table->getColumns()[$cnt]->unsigned();
                    }
                    if (strlen($field['default']) > 0) {
                        $table->getColumns()[$cnt]->default($field['default']);
                    } elseif (is_null($field['default'])) {
                        $table->getColumns()[$cnt]->nullable()->default($field['default']);
                    }
                    if (strlen($field['index']) > 0) {
                        switch ($field['index']) {
                            case 'unique':
                                $table->getColumns()[$cnt]->unique();
                                break;
                            case 'index':
                                $table->getColumns()[$cnt]->index();
                                break;
                            case 'primary':
                                $table->getColumns()[$cnt]->primary();
                                break;
                        }
                    }
                    $cnt++;
                }
                if ($timestamps) {
                    $table->timestamps();
                }
                //dd($table);
            });
        }
    }
}
