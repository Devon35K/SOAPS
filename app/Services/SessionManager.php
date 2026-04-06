<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\User;

class SessionManager
{
    private const SESSION_TIMEOUT = 3600; // 1 hour
    private const CSRF_TOKEN_KEY = 'csrf_token';

    public static function initialize(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_samesite', 'Strict');
            ini_set('session.gc_maxlifetime', self::SESSION_TIMEOUT);

            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                ini_set('session.cookie_secure', 1);
            }

            session_start();
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function isAuthenticated(): bool
    {
        return Auth::check() || (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true);
    }

    public static function isAdmin(): bool
    {
        $user = Auth::user();
        if ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        }
        return ($_SESSION['user']['role'] ?? '') === 'admin' || ($_SESSION['user']['role'] ?? '') === 'super_admin';
    }

    public static function isSuperAdmin(): bool
    {
        $user = Auth::user();
        if ($user) {
            return $user->role === 'super_admin';
        }
        return ($_SESSION['user']['role'] ?? '') === 'super_admin';
    }

    public static function checkTimeout(): bool
    {
        if (!isset($_SESSION['user']['last_activity'])) {
            return false;
        }

        if (time() - $_SESSION['user']['last_activity'] > self::SESSION_TIMEOUT) {
            self::destroy();
            return true;
        }

        $_SESSION['user']['last_activity'] = time();
        return false;
    }

    public static function requireAuth(): void
    {
        self::initialize();

        if (!self::isAuthenticated()) {
            header('Location: /login?message=' . urlencode('Please log in.'));
            exit;
        }

        if (self::checkTimeout()) {
            header('Location: /login?timeout=1');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireAuth();

        if (!self::isAdmin()) {
            header('Location: /dashboard?message=' . urlencode('Access denied.'));
            exit;
        }
    }

    public static function requireSuperAdmin(): void
    {
        self::requireAuth();

        if (!self::isSuperAdmin()) {
            header('Location: /admin?message=' . urlencode('Super Admin access required.'));
            exit;
        }
    }

    public static function getUser(): ?array
    {
        $user = Auth::user();
        if ($user) {
            return [
                'id' => $user->id,
                'student_id' => $user->student_id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'role' => $user->role,
                'approved' => $user->approved,
            ];
        }
        return $_SESSION['user'] ?? null;
    }

    public static function getUserId(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function getCsrfToken(): string
    {
        return $_SESSION['csrf_token'] ?? '';
    }

    public static function validateCsrf(string $token): bool
    {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    public static function regenerateCsrf(): string
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }

    public static function login(User $user): void
    {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = [
            'id' => $user->id,
            'student_id' => $user->student_id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'role' => $user->role,
            'approved' => $user->approved,
            'last_activity' => time(),
        ];
    }

    public static function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    public static function logout(): void
    {
        self::destroy();
    }
}
