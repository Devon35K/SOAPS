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
        $driver = DB::getDriverName();

        // Only create stored procedures for MySQL/MariaDB/PostgreSQL
        if ($driver === 'sqlite') {
            return;
        }

        $this->dropAllProcedures();

        // 1. AddUserIfAllowed - Prevent duplicate emails/student IDs
        DB::unprepared('
            CREATE PROCEDURE AddUserIfAllowed(
                IN p_student_id VARCHAR(50),
                IN p_full_name VARCHAR(255),
                IN p_address VARCHAR(255),
                IN p_email VARCHAR(255),
                IN p_password VARCHAR(255),
                IN p_status ENUM("undergraduate", "alumni"),
                IN p_role VARCHAR(50)
            )
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM users WHERE email = p_email OR student_id = p_student_id
                ) THEN
                    INSERT INTO users (student_id, full_name, address, email, password, status, role, approved, created_at, updated_at)
                    VALUES (p_student_id, p_full_name, p_address, p_email, p_password, p_status, p_role, true, NOW(), NOW());
                    SELECT "User added successfully" AS result;
                ELSE
                    SELECT "Email or Student ID already registered" AS result;
                END IF;
            END
        ');

        // 2. DeleteUserById - Delete by student_id
        DB::unprepared('
            CREATE PROCEDURE DeleteUserById(IN studentId VARCHAR(255))
            BEGIN
                DELETE FROM users WHERE student_id = studentId;
            END
        ');

        // 3. DeleteUserIfAllowed - Delete by user id
        DB::unprepared('
            CREATE PROCEDURE DeleteUserIfAllowed(IN userId INT)
            BEGIN
                DELETE FROM users WHERE id = userId;
            END
        ');

        // 4. GetTotalStudents - Count all users
        DB::unprepared('
            CREATE PROCEDURE GetTotalStudents()
            BEGIN
                SELECT COUNT(*) AS total FROM users;
            END
        ');

        // 5. GetUserByStudentID - Get user details by student_id
        DB::unprepared('
            CREATE PROCEDURE GetUserByStudentID(IN sid VARCHAR(50))
            BEGIN
                SELECT student_id, full_name, address, status, role, approved
                FROM users
                WHERE student_id = sid;
            END
        ');

        // 6. SearchUsers - Search by student_id or full_name
        DB::unprepared('
            CREATE PROCEDURE SearchUsers(IN search_term VARCHAR(255))
            BEGIN
                IF search_term IS NULL OR TRIM(search_term) = "" THEN
                    SELECT student_id, full_name, address, status, role FROM users;
                ELSE
                    SELECT student_id, full_name, address, status, role FROM users
                    WHERE LOWER(student_id) LIKE CONCAT("%", LOWER(search_term), "%")
                       OR LOWER(full_name) LIKE CONCAT("%", LOWER(search_term), "%");
                END IF;
            END
        ');

        // 7. UpdateUserByStudentID - Update user details
        DB::unprepared('
            CREATE PROCEDURE UpdateUserByStudentID(
                IN sid VARCHAR(50),
                IN fname VARCHAR(255),
                IN addr TEXT,
                IN stat VARCHAR(50)
            )
            BEGIN
                UPDATE users
                SET full_name = fname,
                    address = addr,
                    status = stat
                WHERE student_id = sid;
            END
        ');

        // 8. find_user_by_email - Find user by email with role
        DB::unprepared('
            CREATE PROCEDURE find_user_by_email(IN user_email VARCHAR(255))
            BEGIN
                SELECT
                    id, email, password, role, full_name, address, approved
                FROM
                    users
                WHERE
                    email = user_email;
            END
        ');

        // 9. AddAchievement - Add new achievement
        DB::unprepared('
            CREATE PROCEDURE AddAchievement(
                IN p_user_id INT,
                IN p_athlete_name VARCHAR(255),
                IN p_level_of_competition VARCHAR(50),
                IN p_performance VARCHAR(50),
                IN p_number_of_events VARCHAR(50),
                IN p_leadership_role VARCHAR(50),
                IN p_sportsmanship VARCHAR(50),
                IN p_community_impact VARCHAR(50),
                IN p_completeness_of_documents VARCHAR(50),
                IN p_total_points INT,
                IN p_documents TEXT,
                IN p_status ENUM("Pending", "Approved", "Rejected"),
                IN p_rejection_reason TEXT
            )
            BEGIN
                INSERT INTO achievements (
                    user_id, athlete_name, level_of_competition, performance, number_of_events,
                    leadership_role, sportsmanship, community_impact, completeness_of_documents,
                    total_points, documents, status, rejection_reason, submission_date
                ) VALUES (
                    p_user_id, p_athlete_name, p_level_of_competition, p_performance, p_number_of_events,
                    p_leadership_role, p_sportsmanship, p_community_impact, p_completeness_of_documents,
                    p_total_points, p_documents, p_status, p_rejection_reason, NOW()
                );
            END
        ');

        // 10. GetUserAchievements - Get achievements for a user
        DB::unprepared('
            CREATE PROCEDURE GetUserAchievements(IN p_user_id INT)
            BEGIN
                SELECT
                    achievement_id,
                    athlete_name,
                    level_of_competition,
                    performance,
                    number_of_events,
                    leadership_role,
                    sportsmanship,
                    community_impact,
                    completeness_of_documents,
                    total_points,
                    documents,
                    DATE_FORMAT(submission_date, "%m-%d-%Y") AS submission_date,
                    status,
                    rejection_reason
                FROM achievements
                WHERE user_id = p_user_id
                ORDER BY submission_date DESC;
            END
        ');

        // 11. GetLeaderboard - Get leaderboard by status
        DB::unprepared('
            CREATE PROCEDURE GetLeaderboard(IN userStatus VARCHAR(20))
            BEGIN
                SELECT
                    a.athlete_name,
                    SUM(a.total_points) AS total_points
                FROM achievements a
                JOIN users u ON a.user_id = u.id
                WHERE a.status = "Approved" AND u.status = userStatus
                GROUP BY a.user_id, a.athlete_name
                ORDER BY total_points DESC;
            END
        ');

        // 12. CountAdmins - Count admin users
        DB::unprepared('
            CREATE PROCEDURE CountAdmins()
            BEGIN
                SELECT COUNT(*) AS admin_count FROM users WHERE role IN ("admin", "super_admin");
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropAllProcedures();
    }

    /**
     * Drop all stored procedures
     */
    private function dropAllProcedures(): void
    {
        $procedures = [
            'AddUserIfAllowed',
            'DeleteUserById',
            'DeleteUserIfAllowed',
            'GetTotalStudents',
            'GetUserByStudentID',
            'SearchUsers',
            'UpdateUserByStudentID',
            'find_user_by_email',
            'AddAchievement',
            'GetUserAchievements',
            'GetLeaderboard',
            'CountAdmins'
        ];

        foreach ($procedures as $procedure) {
            try {
                DB::unprepared("DROP PROCEDURE IF EXISTS {$procedure}");
            } catch (\Exception $e) {
                // Ignore errors when dropping procedures
            }
        }
    }
};
