<?php
namespace app\controllers;
use \Controller;
use \Response;

class SessionController extends Controller
{
    // Define user roles as constants with your numbering system
    const ROLE_GUEST = 0;    // Not logged in
    const ROLE_USER = 1;      // Usuario normal
    const ROLE_PACIENTE = 2; // Asistente
    const ROLE_ACOMPANANTE = 3; // Institución
    const ROLE_INSTITUCION = 4;     // Administrador
    const ROLE_ADMIN = 5;     // Administrador

    // Constructor
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize role if not set
        if (!isset($_SESSION['usuario_rol'])) {
            $_SESSION['usuario_rol'] = self::ROLE_GUEST;
        }
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['usuario_id']) && $_SESSION['usuario_rol'] > self::ROLE_GUEST;
    }

    /**
     * Get current user role ID
     * @return int
     */
    public static function getRoleId(): int
    {
        return $_SESSION['usuario_rol'] ?? self::ROLE_USER;
    }

    /**
     * Get current user role name
     * @return string
     */
    public static function getRoleName(): string
    {
        $roles = self::getAllRoles();
        return $roles[self::getRoleId()] ?? 'Invitado';
    }

    /**
     * Check if user has a specific role
     * @param int $roleId
     * @return bool
     */
    public static function hasRole(int $roleId): bool
    {
        return self::getRoleId() === $roleId;
    }

    /**
     * Check if user has at least the required role level
     * @param int $minRoleId
     * @return bool
     */
    public static function hasMinRole(int $minRoleId): bool
    {
        return self::getRoleId() >= $minRoleId;
    }

    /**
     * Start a new session for the user with role
     * @param int $userId
     * @param string $userName
     * @param int $roleId
     * @return void
     */
    public static function login(int $userId, string $userName, int $roleId = self::ROLE_USER, ?int $institucionId = null): void
    {
        $_SESSION['usuario_id'] = $userId;
        $_SESSION['usuario_nombre'] = $userName;
        $_SESSION['usuario_rol'] = $roleId;

        // Solo guardamos el ID de la institución si el rol es el correcto y el ID no es null
        if ($roleId === self::ROLE_INSTITUCION && $institucionId !== null) {
            $_SESSION['institucion_id'] = $institucionId;
        }
    }



    /**
     * Require minimum role level for access
     * @param int $requiredRoleId
     * @param string $redirectUrl
     * @return void
     */
    public static function requireRole(int $requiredRoleId, string $redirectUrl = '/login'): void
    {
        if (!self::hasMinRole($requiredRoleId)) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    /**
     * Get all available roles with their names
     * @return array
     */
    public static function getAllRoles(): array
    {
        return [
            self::ROLE_GUEST => 'Invitado',
            self::ROLE_USER => 'Usuario',
            self::ROLE_PACIENTE => 'Paciente',
            self::ROLE_ACOMPANANTE => 'Asistente',
            self::ROLE_INSTITUCION => 'Institución',
            self::ROLE_ADMIN => 'Administrador'
        ];
    }
    public static function getInstitucionID()
    {
        return $_SESSION['institucion_id'] ?? self::ROLE_INSTITUCION;
    }



    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // importante
        }

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }



}