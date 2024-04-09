

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `department_id`, `user_level`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 'Admin', 'admin@app.com', NULL, '$2y$10$YqQ3G7d8VjCnPQQkCRID5eZC5rxbTLWwSQt66elaRj7C6eaWoawNe', NULL, NULL, NULL, NULL, '2024-01-11 07:08:26', '2024-04-08 11:41:23'),
(2, 0, 1, 'Director', 'director@app.com', NULL, '$2y$10$ioQPh2SGaXf9LFk2N8D2R.Kcbs/PniqTvLymbeguM1H15i/18rbVe', NULL, NULL, NULL, NULL, '2024-01-11 07:08:26', '2024-01-15 06:15:08'),
(3, 0, 2, 'Manager', 'manager@app.com', NULL, '$2y$10$gRGdus8cnwX.mpTt.C27y.eI6v8O4AzjQPXimQo9KXhl5u0J2aNtO', NULL, NULL, NULL, NULL, '2024-01-11 07:08:27', '2024-01-15 06:15:01'),
(4, 0, 3, 'Employee', 'employee@app.com', NULL, '$2y$10$nPNxAJ/aQ5NorCSeR0C0nO3ZM.FiosrpBwR9rvrbnF4QyZfX2kllC', NULL, NULL, NULL, NULL, '2024-01-11 07:08:27', '2024-01-15 06:15:03'),
(5, 1, 1, 'IT Director', 'itdirector@app.com', NULL, '$2y$10$Mxb9Fmw6BpdOUJJNkpjrw.cUXbF36iqQwJnOjvBt8BGSPcRaohYua', NULL, NULL, NULL, NULL, '2024-01-11 07:54:29', '2024-04-08 06:49:59'),
(6, 1, 2, 'IT Manager', 'itmanager@app.com', NULL, '$2y$10$R2UuOOhK2n8qDnzvETEzbOtrvslOYX1BwBcp8dWJUbxB2tO3OMZ7e', NULL, NULL, NULL, NULL, '2024-01-11 07:54:59', '2024-04-08 06:50:36'),
(7, 1, 3, 'IT Employee 1', 'itemployee1@app.com', NULL, '$2y$10$z2Bfb.Lo2L9Br89xC5yk4OTSZVu6A6u.uGJnsm0sLugRw7xak0pkC', NULL, NULL, NULL, NULL, '2024-01-11 07:57:08', '2024-04-08 06:50:52'),
(8, 1, 3, 'IT Employee 2', 'itemployee2@app.com', NULL, '$2y$10$awDhRERAuyvz9Bnce5t/beS8PjELgPm7qVS1P7jLEpShsJwpNIE9e', NULL, NULL, NULL, NULL, '2024-01-11 07:57:32', '2024-04-08 06:51:33'),
(9, 2, 1, 'HR Director', 'hrdirector@app.com', NULL, '$2y$10$KrKPeO8oyFGJuzCYxeGNr.mIm6Jxev0XHhbIQKezX0kg4vFUwEK2C', NULL, NULL, NULL, NULL, '2024-01-11 07:57:57', '2024-04-08 06:51:49'),
(10, 2, 2, 'HR Manager', 'hrmanager@app.com', NULL, '$2y$10$C971mFbBIPyt2AvF.XT0auQLz.rBv/pO4pRAb8Kllex.c8W534Tli', NULL, NULL, NULL, NULL, '2024-01-11 07:58:18', '2024-04-08 06:52:05'),
(11, 2, 3, 'HR Employee', 'hremployee@app.com', NULL, '$2y$10$YABCd3i.oO/snLxO.jh1s.CeOe8kDuoLv800Lk3qZNc7N9DkYI8Ea', NULL, NULL, NULL, NULL, '2024-01-11 07:59:00', '2024-04-08 06:52:23');


