ALTER TABLE users
ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'active' AFTER is_superuser; 