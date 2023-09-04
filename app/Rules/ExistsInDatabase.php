<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class ExistsInDatabase implements Rule
{
    protected $table;
    protected $column;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table($this->table)->where($this->column, $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute entered is not found in the database.';
    }
}
