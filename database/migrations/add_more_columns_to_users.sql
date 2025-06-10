ALTER TABLE users ADD COLUMN permissions TEXT NULL AFTER status;
ALTER TABLE users ADD COLUMN verification_token VARCHAR(255) NULL AFTER password_reset_token;
ALTER TABLE users ADD COLUMN password_reset_token VARCHAR(255) NULL AFTER verification_token; 