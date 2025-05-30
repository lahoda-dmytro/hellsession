<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $joined_date
 * @property string|null $last_login
 * @property int $is_superuser (0 user, 1 admin)
 * @property string|null $permissions
 * @property string $status  ('active', 'inactive', 'blocked', 'pending_verification')
 * @property string|null $verification_token
 * @property string|null $password_reset_token
 * @property string $created_at
 * @property string $updated_at
 */

class User extends Model {
    protected string $table = 'users';
}