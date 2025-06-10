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
 * @property string $created_at
 * @property string $updated_at
 */

class User extends Model {
    protected string $table = 'users';
    public function login(string $usernameOrEmail, string $password): bool {
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
    public function register(array $data): bool {
        try {
            $this->first_name = $data['first_name'] ?? '';
            $this->last_name = $data['last_name'] ?? '';
            $this->username = $data['username'] ?? '';
            $this->email = $data['email'] ?? '';
            $this->password = password_hash($data['password'], PASSWORD_BCRYPT);
            $this->joined_date = date('Y-m-d H:i:s');
            $this->created_at = date('Y-m-d H:i:s');
            $this->updated_at = date('Y-m-d H:i:s');

            if ($this->save()) {
                $this->loginUserIntoSession($this);

                try {
                    $this->last_login = date('Y-m-d H:i:s');
                    $this->save();
                } catch (\Throwable $e) {
                    error_log("Error setting last_login after registration: " . $e->getMessage());
                }

                return true;
            }
            error_log("Failed to save user during registration");
            return false;
        } catch (\Throwable $e) {
            error_log("Error during user registration: " . $e->getMessage());
            return false;
        }
    }
}