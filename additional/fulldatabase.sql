-- ============================================
-- AOT Railway Staff Management System
-- Complete Database Schema
-- ============================================

-- Create Database
CREATE DATABASE IF NOT EXISTS aot_railway_staff_management;
USE aot_railway_staff_management;

-- ============================================
-- 1. USER ROLES TABLE
-- ============================================
CREATE TABLE `user_roles` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `role_name` VARCHAR(50) NOT NULL,
    `role_slug` VARCHAR(50) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert User Roles
INSERT INTO `user_roles` (`role_name`, `role_slug`, `description`) VALUES
('Station User', 'station_user', 'Regular station user responsible for submitting monthly reports'),
('Super Administrator', 'super_admin', 'System administrator with full access to all features');

-- ============================================
-- 2. STATIONS TABLE (106 Stations)
-- ============================================
CREATE TABLE `stations` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `station_code` VARCHAR(10) NOT NULL UNIQUE,
    `station_name` VARCHAR(255) NOT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert All 106 Railway Stations
INSERT INTO `stations` (`station_code`, `station_name`) VALUES
('ABN', 'Abangahawatta'),
('ADA', 'Aluthgama'),
('AGB', 'Agbopura'),
('AHN', 'Ahungalle'),
('ALN', 'Alawwa'),
('AMB', 'Ambewela'),
('AMN', 'Ambalangoda'),
('ANP', 'Anuradhapura'),
('APO', 'Ampara'),
('ARL', 'Aralaganwila'),
('ATL', 'Atale'),
('AVS', 'Awissawella'),
('BAD', 'Badulla'),
('BAL', 'Balapitiya'),
('BAN', 'Bandarawela'),
('BAT', 'Batticaloa'),
('BEL', 'Beliatta'),
('BEN', 'Bentota'),
('BIA', 'Bandaranaike International Airport'),
('BLA', 'Black Pool'),
('BON', 'Boossa'),
('BPT', 'Bopaththalawa'),
('BRL', 'Beruwala'),
('CHI', 'Chilaw'),
('CHN', 'Chunnakam'),
('CHO', 'Chavakachcheri'),
('CKB', 'Colombo Kingsbury'),
('CKE', 'Colombo Terminus'),
('CMC', 'Commercial Office'),
('COL', 'Colombo Fort'),
('COM', 'Commercial Office'),
('COP', 'Colombo Port'),
('DAG', 'Dagama'),
('DAN', 'Dandugama'),
('DAR', 'Daruwa'),
('DEE', 'Dehiwala'),
('DEM', 'Demodara'),
('DIA', 'Diyathalawa'),
('DIM', 'Dimbula'),
('DOD', 'Dodanduwa'),
('EGO', 'Egoda Uyana'),
('ELE', 'Elpitiya'),
('ELL', 'Ella'),
('ELP', 'Elpitiya'),
('ERA', 'Eravur'),
('ERU', 'Erukkalampiddy'),
('FOT', 'Fort'),
('GAL', 'Galle'),
('GAM', 'Gampaha'),
('GAN', 'Ganemulla'),
('GIN', 'Gintota'),
('GIR', 'Giritale'),
('GLM', 'Galabada'),
('GOO', 'Goodshed'),
('GPH', 'Gampola'),
('GRD', 'Grandpass'),
('HAB', 'Habarana'),
('HAD', 'Hadirawalana'),
('HAK', 'Hakmana'),
('HAP', 'Haputale'),
('HAT', 'Hatharaliyadda'),
('HEN', 'Hendala'),
('HIK', 'Hikkaduwa'),
('HIN', 'Hingurakgoda'),
('HOM', 'Homagama'),
('IKB', 'Ink Blot'),
('ILL', 'Illavalai'),
('JAF', 'Jaffna'),
('KAK', 'Kakkapalliya'),
('KAL', 'Kalutara North'),
('KAN', 'Kandy'),
('KAT', 'Katunayake'),
('KEG', 'Kegalle'),
('KEK', 'Kekirawa'),
('KEL', 'Kelaniya'),
('KIN', 'Kingsbury'),
('KIR', 'Kiralogama'),
('KKS', 'Kankesanthurai'),
('KOC', 'Kochchikade'),
('KOS', 'Kosgoda'),
('KOT', 'Kottawa'),
('KUR', 'Kurunegala'),
('LUN', 'Lunuwila'),
('MAD', 'Madampe'),
('MAH', 'Maho'),
('MAN', 'Mannar'),
('MAR', 'Maradana'),
('MAT', 'Matara'),
('MDA', 'Maradana'),
('MED', 'Medawachchiya'),
('MIN', 'Minuwangoda'),
('MIR', 'Mirigama'),
('MOR', 'Moratuwa'),
('MTP', 'Mount Lavinia'),
('NAW', 'Nawalapitiya'),
('NEG', 'Negombo'),
('NIT', 'Nittambuwa'),
('NOR', 'Norton Bridge'),
('NUG', 'Nugegoda'),
('NUR', 'Nuriya'),
('ODD', 'Oddusuddan'),
('PAD', 'Padukka'),
('PAI', 'Paiyagala'),
('PAL', 'Palavi'),
('PAN', 'Panadura'),
('PAR', 'Paranthan'),
('PAT', 'Pattipola'),
('PER', 'Peradeniya'),
('PIL', 'Piliyandala'),
('POL', 'Polgahawela'),
('PUT', 'Puttalam'),
('RAG', 'Ragama'),
('RAT', 'Ratmalana'),
('SEV', 'Seeduwa'),
('SIG', 'Sigiriya'),
('TAL', 'Talaimannar'),
('THA', 'Thambuttegama'),
('TRI', 'Trincomalee'),
('VAN', 'Vandaramullai'),
('VEY', 'Veyangoda'),
('WAD', 'Wadduwa'),
('WAT', 'Watawala'),
('WEL', 'Wellawatte'),
('YAT', 'Yatiyantota');

-- ============================================
-- 3. USERS TABLE
-- ============================================
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(255) NOT NULL,
    `nic_number` VARCHAR(20) NOT NULL UNIQUE,
    `whatsapp_mobile` VARCHAR(15) NOT NULL,
    `station_id` BIGINT UNSIGNED NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `remember_token` VARCHAR(100) NULL,
    `email_verified_at` TIMESTAMP NULL,
    `last_login_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`station_id`) REFERENCES `stations`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (`role_id`) REFERENCES `user_roles`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_users_nic` (`nic_number`),
    INDEX `idx_users_station` (`station_id`),
    INDEX `idx_users_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Super Admin
INSERT INTO `users` (`full_name`, `nic_number`, `whatsapp_mobile`, `station_id`, `password`, `role_id`, `status`) VALUES
('Super Administrator', '999999999999', '0771234567', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 'active');
-- Default password: password (bcrypt encrypted)

-- ============================================
-- 4. DESIGNATIONS TABLE
-- ============================================
CREATE TABLE `designations` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `designation_name` VARCHAR(255) NOT NULL,
    `designation_code` VARCHAR(50) NULL,
    `sort_order` INT DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert All Designations
INSERT INTO `designations` (`designation_name`, `sort_order`) VALUES
('D.St. (Officer)', 1),
('Gen.D.St. (Super Grade)', 2),
('Controller (Special)', 3),
('Controller I', 4),
('Controller II', 5),
('Controller III', 6),
('Station Master 1', 7),
('Station Master II', 8),
('Station Master III', 9),
('Policeman', 10),
('Pointsman', 11),
('Shunter', 12),
('Customs Inspector', 13),
('Asst. T.C.V. (TTE)', 14),
('Asst. T.C.I. (TTI)', 15),
('D.Co.M.', 16),
('D.Co.M. (Communications)', 17),
('DKS(G)', 18),
('N.B.Co.', 19),
('N.B.S.', 20),
('Serang', 21),
('Gen.T.Co. (TC)', 22),
('LAMP MEN', 23),
('Yard Master', 24),
('YARD MARSTER', 25),
('Yard Motion', 26),
('TRAIN OPERATOR', 27),
('(Co.S.S.) Co.Co.S.', 28),
('LISTER DRIVER', 29),
('Co.V.S.', 30),
('Apprentice / Instructor', 31),
('Ni.Me.Se.', 32),
('Messenger', 33),
('Motor Lorry Driver', 34),
('Butler', 35);

-- ============================================
-- 5. MONTHLY REPORTS TABLE (Parent)
-- ============================================
CREATE TABLE `monthly_reports` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `report_identifier` VARCHAR(20) NOT NULL UNIQUE,
    `station_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `year` INT NOT NULL,
    `month` VARCHAR(3) NOT NULL,
    `month_full` VARCHAR(20) NOT NULL,
    `submission_status` ENUM('draft', 'submitted', 'pending') DEFAULT 'submitted',
    `submitted_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`station_id`) REFERENCES `stations`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE KEY `unique_station_year_month` (`station_id`, `year`, `month`),
    INDEX `idx_report_identifier` (`report_identifier`),
    INDEX `idx_station_year_month` (`station_id`, `year`, `month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 6. REPORT DETAILS TABLE (Designation-specific data)
-- ============================================
CREATE TABLE `report_details` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `monthly_report_id` BIGINT UNSIGNED NOT NULL,
    `designation_id` BIGINT UNSIGNED NOT NULL,
    `approved_cadre` INT NOT NULL DEFAULT 0,
    `staff_on_duty` INT NOT NULL DEFAULT 0,
    `vacancies` INT NOT NULL DEFAULT 0,
    `relief_inward` INT NOT NULL DEFAULT 0,
    `relief_outward` INT NOT NULL DEFAULT 0,
    `relief_work_station` VARCHAR(255) NULL,
    `temp_transfer_inward` INT NOT NULL DEFAULT 0,
    `temp_transfer_outward` INT NOT NULL DEFAULT 0,
    `temp_transfer_work_station` VARCHAR(255) NULL,
    `excess` INT NOT NULL DEFAULT 0,
    `foreign_leave_overseas` INT NOT NULL DEFAULT 0,
    `retirements_details` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`monthly_report_id`) REFERENCES `monthly_reports`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`designation_id`) REFERENCES `designations`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE KEY `unique_report_designation` (`monthly_report_id`, `designation_id`),
    INDEX `idx_report_designation` (`monthly_report_id`, `designation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 7. PASSWORD RESETS TABLE
-- ============================================
CREATE TABLE `password_resets` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `expires_at` TIMESTAMP NOT NULL,
    `used` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX `idx_password_resets_token` (`token`),
    INDEX `idx_password_resets_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 8. PASSWORD CHANGE HISTORY TABLE
-- ============================================
CREATE TABLE `password_change_history` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `changed_by` BIGINT UNSIGNED NULL,
    `change_type` ENUM('self', 'admin_reset', 'admin_change') NOT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`changed_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX `idx_password_history_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 9. AUDIT LOGS TABLE
-- ============================================
CREATE TABLE `audit_logs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `action` VARCHAR(255) NOT NULL,
    `module` VARCHAR(100) NOT NULL,
    `record_id` BIGINT UNSIGNED NULL,
    `old_data` JSON NULL,
    `new_data` JSON NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX `idx_audit_user` (`user_id`),
    INDEX `idx_audit_module` (`module`),
    INDEX `idx_audit_action` (`action`),
    INDEX `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 10. SYSTEM NOTIFICATIONS TABLE
-- ============================================
CREATE TABLE `system_notifications` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `type` ENUM('info', 'warning', 'danger', 'success') DEFAULT 'info',
    `read_status` TINYINT(1) DEFAULT 0,
    `notification_type` ENUM('missing_submission', 'report_updated', 'system_alert', 'user_management') NOT NULL,
    `reference_id` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `read_at` TIMESTAMP NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX `idx_notifications_user` (`user_id`),
    INDEX `idx_notifications_read` (`read_status`),
    INDEX `idx_notifications_type` (`notification_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 11. MISSING SUBMISSIONS TRACKING TABLE
-- ============================================
CREATE TABLE `missing_submissions_tracking` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `station_id` BIGINT UNSIGNED NOT NULL,
    `year` INT NOT NULL,
    `month` VARCHAR(3) NOT NULL,
    `notification_sent` TINYINT(1) DEFAULT 0,
    `notification_date` TIMESTAMP NULL,
    `reminder_count` INT DEFAULT 0,
    `last_reminder_date` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`station_id`) REFERENCES `stations`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY `unique_missing_submission` (`station_id`, `year`, `month`),
    INDEX `idx_missing_station` (`station_id`),
    INDEX `idx_missing_year_month` (`year`, `month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 12. SESSIONS TABLE
-- ============================================
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` TEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX `idx_sessions_user` (`user_id`),
    INDEX `idx_sessions_last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 13. REPORT EXPORTS TABLE (Tracking generated reports)
-- ============================================
CREATE TABLE `report_exports` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `generated_by` BIGINT UNSIGNED NOT NULL,
    `report_type` ENUM('monthly', 'quarterly', 'station_wise', 'user_wise', 'vacancy_summary', 'staff_summary', 'missing_submissions') NOT NULL,
    `parameters` JSON NULL,
    `file_path` VARCHAR(255) NULL,
    `file_type` ENUM('pdf', 'excel', 'csv') DEFAULT 'pdf',
    `generated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`generated_by`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_exports_user` (`generated_by`),
    INDEX `idx_exports_type` (`report_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 14. QUARTERLY REPORT SUMMARIES TABLE
-- ============================================
CREATE TABLE `quarterly_report_summaries` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `year` INT NOT NULL,
    `quarter` TINYINT NOT NULL COMMENT '1,2,3,4',
    `station_id` BIGINT UNSIGNED NOT NULL,
    `total_staff` INT DEFAULT 0,
    `total_vacancies` INT DEFAULT 0,
    `total_relief_inward` INT DEFAULT 0,
    `total_relief_outward` INT DEFAULT 0,
    `total_temp_transfer_inward` INT DEFAULT 0,
    `total_temp_transfer_outward` INT DEFAULT 0,
    `total_excess` INT DEFAULT 0,
    `total_foreign_leave` INT DEFAULT 0,
    `retirements_summary` TEXT NULL,
    `generated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`station_id`) REFERENCES `stations`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE KEY `unique_quarterly_summary` (`year`, `quarter`, `station_id`),
    INDEX `idx_quarterly_station` (`station_id`),
    INDEX `idx_quarterly_year` (`year`, `quarter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- STORED PROCEDURES
-- ============================================

-- Procedure: Generate Report Identifier
DELIMITER $$
CREATE PROCEDURE `GenerateReportIdentifier`(
    IN p_year INT,
    IN p_month VARCHAR(3),
    IN p_station_code VARCHAR(10),
    OUT p_identifier VARCHAR(20)
)
BEGIN
    SET p_identifier = CONCAT(p_year, '-', UPPER(p_month), '-', UPPER(p_station_code));
END$$
DELIMITER ;

-- Procedure: Check Missing Submissions for Current Month
DELIMITER $$
CREATE PROCEDURE `CheckMissingSubmissions`(
    IN p_year INT,
    IN p_month VARCHAR(3)
)
BEGIN
    SELECT 
        s.id AS station_id,
        s.station_code,
        s.station_name,
        u.id AS user_id,
        u.full_name,
        CASE WHEN mr.id IS NULL THEN 'MISSING' ELSE 'SUBMITTED' END AS submission_status
    FROM stations s
    LEFT JOIN users u ON s.id = u.station_id AND u.role_id = 1 AND u.status = 'active'
    LEFT JOIN monthly_reports mr ON s.id = mr.station_id 
        AND mr.year = p_year 
        AND UPPER(mr.month) = UPPER(p_month)
    WHERE mr.id IS NULL
    ORDER BY s.station_code;
END$$
DELIMITER ;

-- Procedure: Get Station Submission Statistics
DELIMITER $$
CREATE PROCEDURE `GetStationSubmissionStats`(
    IN p_year INT,
    IN p_month VARCHAR(3)
)
BEGIN
    SELECT 
        COUNT(DISTINCT s.id) AS total_stations,
        COUNT(DISTINCT mr.station_id) AS submitted_stations,
        (COUNT(DISTINCT s.id) - COUNT(DISTINCT mr.station_id)) AS pending_stations
    FROM stations s
    LEFT JOIN monthly_reports mr ON s.id = mr.station_id 
        AND mr.year = p_year 
        AND UPPER(mr.month) = UPPER(p_month);
END$$
DELIMITER ;

-- ============================================
-- VIEWS
-- ============================================

-- View: User Station Details
CREATE OR REPLACE VIEW `v_user_station_details` AS
SELECT 
    u.id AS user_id,
    u.full_name,
    u.nic_number,
    u.whatsapp_mobile,
    u.status AS user_status,
    s.id AS station_id,
    s.station_code,
    s.station_name,
    r.role_name,
    r.role_slug,
    u.last_login_at,
    u.created_at
FROM users u
LEFT JOIN stations s ON u.station_id = s.id
JOIN user_roles r ON u.role_id = r.id;

-- View: Monthly Report Summary
CREATE OR REPLACE VIEW `v_monthly_report_summary` AS
SELECT 
    mr.id AS report_id,
    mr.report_identifier,
    mr.year,
    mr.month,
    mr.month_full,
    s.station_code,
    s.station_name,
    u.full_name AS submitted_by,
    COUNT(rd.id) AS total_designations,
    SUM(rd.approved_cadre) AS total_approved_cadre,
    SUM(rd.staff_on_duty) AS total_staff_on_duty,
    SUM(rd.vacancies) AS total_vacancies,
    SUM(rd.relief_inward) AS total_relief_inward,
    SUM(rd.relief_outward) AS total_relief_outward,
    SUM(rd.temp_transfer_inward) AS total_temp_transfer_inward,
    SUM(rd.temp_transfer_outward) AS total_temp_transfer_outward,
    SUM(rd.excess) AS total_excess,
    SUM(rd.foreign_leave_overseas) AS total_foreign_leave,
    mr.submission_status,
    mr.submitted_at
FROM monthly_reports mr
JOIN stations s ON mr.station_id = s.id
JOIN users u ON mr.user_id = u.id
LEFT JOIN report_details rd ON mr.id = rd.monthly_report_id
GROUP BY mr.id;

-- View: Pending Submissions
CREATE OR REPLACE VIEW `v_pending_submissions` AS
SELECT 
    s.id AS station_id,
    s.station_code,
    s.station_name,
    u.id AS user_id,
    u.full_name AS user_name,
    u.whatsapp_mobile,
    YEAR(CURRENT_DATE()) AS current_year,
    UPPER(DATE_FORMAT(CURRENT_DATE(), '%b')) AS current_month,
    DATE_FORMAT(CURRENT_DATE(), '%M') AS current_month_full
FROM stations s
LEFT JOIN users u ON s.id = u.station_id AND u.role_id = 1 AND u.status = 'active'
WHERE s.id NOT IN (
    SELECT DISTINCT mr.station_id 
    FROM monthly_reports mr 
    WHERE mr.year = YEAR(CURRENT_DATE()) 
    AND UPPER(mr.month) = UPPER(DATE_FORMAT(CURRENT_DATE(), '%b'))
)
AND s.status = 'active';

-- ============================================
-- TRIGGERS
-- ============================================

-- Trigger: Auto-generate report identifier before insert
DELIMITER $$
CREATE TRIGGER `trg_monthly_reports_before_insert` 
BEFORE INSERT ON `monthly_reports` 
FOR EACH ROW
BEGIN
    DECLARE v_station_code VARCHAR(10);
    
    -- Get station code
    SELECT station_code INTO v_station_code 
    FROM stations 
    WHERE id = NEW.station_id;
    
    -- Generate report identifier
    SET NEW.report_identifier = CONCAT(NEW.year, '-', UPPER(NEW.month), '-', UPPER(v_station_code));
    
    -- Set month full name
    SET NEW.month_full = CASE UPPER(NEW.month)
        WHEN 'JAN' THEN 'January'
        WHEN 'FEB' THEN 'February'
        WHEN 'MAR' THEN 'March'
        WHEN 'APR' THEN 'April'
        WHEN 'MAY' THEN 'May'
        WHEN 'JUN' THEN 'June'
        WHEN 'JUL' THEN 'July'
        WHEN 'AUG' THEN 'August'
        WHEN 'SEP' THEN 'September'
        WHEN 'OCT' THEN 'October'
        WHEN 'NOV' THEN 'November'
        WHEN 'DEC' THEN 'December'
        ELSE NEW.month
    END;
END$$
DELIMITER ;

-- Trigger: Log user password changes
DELIMITER $$
CREATE TRIGGER `trg_password_change_history_after_update` 
AFTER UPDATE ON `users` 
FOR EACH ROW
BEGIN
    IF OLD.password != NEW.password THEN
        INSERT INTO password_change_history (
            user_id, 
            changed_by, 
            change_type, 
            ip_address, 
            user_agent
        ) VALUES (
            NEW.id,
            NEW.id,
            'self',
            NULL,
            NULL
        );
    END IF;
END$$
DELIMITER ;

-- ============================================
-- ADDITIONAL INDEXES FOR PERFORMANCE
-- ============================================

-- Composite indexes for common queries
CREATE INDEX `idx_report_details_report` ON `report_details`(`monthly_report_id`);
CREATE INDEX `idx_monthly_reports_status` ON `monthly_reports`(`submission_status`);
CREATE INDEX `idx_users_status` ON `users`(`status`);
CREATE INDEX `idx_users_role_status` ON `users`(`role_id`, `status`);

-- ============================================
-- SAMPLE DATA FOR TESTING (Optional)
-- ============================================

-- Sample Station User (password: password)
INSERT INTO `users` (`full_name`, `nic_number`, `whatsapp_mobile`, `station_id`, `password`, `role_id`, `status`) VALUES
('Sample Station User', '199912345678', '0777654321', 
    (SELECT id FROM stations WHERE station_code = 'BRL'), 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    1, 
    'active');

-- ============================================
-- END OF DATABASE SCHEMA
-- ============================================