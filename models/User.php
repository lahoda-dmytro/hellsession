<?php

namespace models;

use classes\Model;
use classes\Core;
use classes\Post;

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


    public function login(string $usernameOrEmail, string $password): bool {
        $core = Core::getInstance();


        $user = static::findOneWhere(['username' => $usernameOrEmail]);
        if (!$user) {
            $user = static::findOneWhere(['email' => $usernameOrEmail]);
        }


        if ($user && password_verify($password, $user->password)) {
            $this->loginUserIntoSession($user);

            if ($user instanceof User) {
                try {
                    $user->last_login = date('Y-m-d H:i:s');
                    $user->save();
                } catch (\Throwable $e) {
                    error_log("Error updating last_login for user " . $user->id . ": " . $e->getMessage());
                }
            }
            return true;
        }

        return false;
    }


    public function loginUserIntoSession(User $user): void {
        $core = Core::getInstance();
        $core->session->set('user_id', $user->id);
        $core->session->set('username', $user->username);
        $core->session->set('is_superuser', $user->is_superuser);
    }


    public static function isLoggedIn(): bool {
        return Core::getInstance()->session->isLoggedIn();
    }


    public static function getCurrentUser(): ?User {
        $userId = Core::getInstance()->session->get('user_id');
        if ($userId) {
            return static::find($userId);
        }
        return null;
    }


    public static function logout(): void {
        $core = Core::getInstance();
        $core->session->remove('user_id');
        $core->session->remove('username');
        $core->session->remove('is_superuser');
        $core->session->clear();
    }
    public static function isUsernameOrEmailTaken(string $username, string $email): bool {
        return static::findOneWhere(['username' => $username]) !== null
            || static::findOneWhere(['email' => $email]) !== null;
    }

}