<?php
/**
 * Classe responsável por criar base de dados tanto no momento do registro
 * quanto pelo painel do administrador
 *
 * @author Joás
 */

namespace App\Tenant\Database;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
class DatabaseManager {
    public function createDatabase(Empresa $empresa) {
        return DB::statement("
            CREATE DATABASE {$empresa->db_base} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");
    }
}
