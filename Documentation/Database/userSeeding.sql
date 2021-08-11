-- -----------------------------------------------------
-- Insert table Profile
-- -----------------------------------------------------
INSERT INTO `user` 
(`id`, `firstname`, `secondname`, `p_surname`, `m_surname`, `birthdate`, `rut_number`, `rut_digit`, `password`, `email`, `profile_id`, `created_at`, `updated_at`, `deleted_at`) VALUES 
(NULL, 'Admin', NULL, 'System', NULL, '2021-08-10', '11111111', '1', 'Admin123', 'admin@example.com', '1', current_timestamp(), current_timestamp(), NULL);