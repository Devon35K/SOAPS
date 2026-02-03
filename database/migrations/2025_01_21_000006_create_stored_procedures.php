<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create AddAdminIfAllowed stored procedure
        DB::unprepared('
            CREATE PROCEDURE AddAdminIfAllowed(
                IN p_full_name VARCHAR(255),
                IN p_address VARCHAR(255),
                IN p_email VARCHAR(255),
                IN p_password VARCHAR(255),
                IN p_status ENUM("undergraduate", "alumni")
            )
            BEGIN
                DECLARE admin_count INT DEFAULT 0;
                DECLARE result_msg VARCHAR(255);
                
                SELECT COUNT(*) INTO admin_count FROM admins;
                
                IF admin_count < 10 THEN
                    INSERT INTO admins (full_name, address, email, password, status, created_at, updated_at)
                    VALUES (p_full_name, p_address, p_email, p_password, p_status, NOW(), NOW());
                    
                    SET result_msg = CONCAT("Admin ", p_email, " added successfully. Total admins: ", admin_count + 1);
                ELSE
                    SET result_msg = "Maximum number of admins reached. Cannot add more admins.";
                END IF;
                
                SELECT result AS result;
            END
        ');

        // Create GetTotalStudents stored procedure
        DB::unprepared('
            CREATE PROCEDURE GetTotalStudents()
            BEGIN
                SELECT COUNT(*) AS total FROM users;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS AddAdminIfAllowed');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetTotalStudents');
    }
};
