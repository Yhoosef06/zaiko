<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentAbbreToDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            Schema::table('departments', function (Blueprint $table) {
                $table->string('department_abbre')->nullable()->after('department_name'); // Add the 'department_abbre' column after 'department_name'
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            Schema::table('departments', function (Blueprint $table) {
                $table->dropColumn('department_abbre'); // Define how to drop the 'department_abbre' column if needed to rollback
            });
        });
    }
}
