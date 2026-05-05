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

        // Only create triggers for MySQL/MariaDB
        if ($driver === 'sqlite') {
            return;
        }

        // Drop existing triggers first
        $this->dropAllTriggers();

        // 1. Trigger for account_approvals status changes
        DB::unprepared('
            CREATE TRIGGER after_account_approval_update
            AFTER UPDATE ON account_approvals
            FOR EACH ROW
            BEGIN
                DECLARE notification_message TEXT;

                IF NEW.approval_status != OLD.approval_status THEN
                    SET notification_message = CASE NEW.approval_status
                        WHEN "approved" THEN CONCAT("Your account is approved. Welcome, ", NEW.full_name, "!")
                        WHEN "rejected" THEN CONCAT("Your account request for ", NEW.full_name, " has been rejected.")
                        ELSE NULL
                    END;

                    IF notification_message IS NOT NULL THEN
                        INSERT INTO notifications (user_id, message, timestamp)
                        SELECT u.id, notification_message, CURRENT_TIMESTAMP
                        FROM users u
                        WHERE u.email = NEW.email AND u.student_id = NEW.student_id;
                    END IF;
                END IF;
            END
        ');

        // 2. Trigger for new document submissions
        DB::unprepared('
            CREATE TRIGGER after_submission_insert
            AFTER INSERT ON submissions
            FOR EACH ROW
            BEGIN
                INSERT INTO notifications (user_id, message, timestamp)
                VALUES (NEW.user_id, CONCAT("You have submitted a new document: \"", NEW.document_type, "\"."), CURRENT_TIMESTAMP);
            END
        ');

        // 3. Trigger for submission status changes
        DB::unprepared('
            CREATE TRIGGER after_submission_update
            AFTER UPDATE ON submissions
            FOR EACH ROW
            BEGIN
                DECLARE notification_message TEXT;

                IF NEW.status != OLD.status THEN
                    SET notification_message = CASE NEW.status
                        WHEN "pending" THEN CONCAT("Your submission \"", NEW.document_type, "\" is now pending.")
                        WHEN "approved" THEN CONCAT("Your submission \"", NEW.document_type, "\" has been approved.")
                        WHEN "rejected" THEN CONCAT("Your submission \"", NEW.document_type, "\" has been rejected. Reason: ", IFNULL(NEW.comments, "No comments provided."))
                    END;

                    INSERT INTO notifications (user_id, message, timestamp)
                    VALUES (NEW.user_id, notification_message, CURRENT_TIMESTAMP);
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropAllTriggers();
    }

    /**
     * Drop all triggers
     */
    private function dropAllTriggers(): void
    {
        $triggers = [
            'after_account_approval_update',
            'after_submission_insert',
            'after_submission_update'
        ];

        foreach ($triggers as $trigger) {
            try {
                DB::unprepared("DROP TRIGGER IF EXISTS {$trigger}");
            } catch (\Exception $e) {
                // Ignore errors when dropping triggers
            }
        }
    }
};
