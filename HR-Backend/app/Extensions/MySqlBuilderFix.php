<?php

namespace App\Extensions;

use Illuminate\Database\Schema\MySqlBuilder;

class MySqlBuilderFix extends MySqlBuilder
{
    /**
     * Determine if the given table exists.
     *
     * @param  string|array  $table
     * @return bool
     */
    public function hasTable($table)
    {
        // If $table is an array, only use the first element
        if (is_array($table)) {
            $table = $table[0];
        }

        $table = $this->connection->getTablePrefix().$table;

        return count($this->connection->selectFromWriteConnection(
            $this->grammar->compileTableExists(), [$this->connection->getDatabaseName(), $table]
        )) > 0;
    }
}
