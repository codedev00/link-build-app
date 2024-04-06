<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
       
        DB::unprepared('
        CREATE TRIGGER trigger_links AFTER INSERT ON tbl_usersettings
        FOR EACH ROW
        BEGIN
            -- Your trigger logic goes here
            -- Example:
            DECLARE my_id VARCHAR(255);
            SELECT storename INTO my_id FROM tbl_usersettings WHERE id = NEW.id;
            INSERT INTO tbl_inbound (outbound_store) VALUES (my_id);
        END
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_links;');
    }
};
