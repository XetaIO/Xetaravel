<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Xetaravel\Models\User;

class ModelHasRolesTableSeeder extends Seeder
{

    protected array $allSites = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
        26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51
    ];

    protected array $allSitesExceptVerdunSiege = [
        2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
        26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51
    ];

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'e.fevre@bds.coop')->first();
        $user->assignRolesToSites('Développeur', $this->allSites);
        $user->assignRolesToSites('Responsable Adjoint Selvah', 2);

        $user = User::where('email', 'f.lequeu@bds.coop')->first();
        $user->assignRolesToSites('Responsable Selvah', 2);
        $user->assignRolesToSites('Responsable Extrusel', 3);

        $user = User::where('email', 'a.moindrot@bds.coop')->first();
        $user->assignRolesToSites('Opérateur Selvah', 2);

        $user = User::where('email', 'jm.briset@bds.coop')->first();
        $user->assignRolesToSites('Opérateur Selvah', 2);

        $user = User::where('email', 'a.bert@bds.coop')->first();
        $user->assignRolesToSites('Opérateur Selvah', 2);

        $user = User::where('email', 'c.brocot@bds.coop')->first();
        $user->assignRolesToSites('Assistant(e) Qualité Filiale', [2, 3, 4]);

        $user = User::where('email', 'c.gateau@bds.coop')->first();
        $user->assignRolesToSites('Responsable Silo', [6, 7, 21, 30]);

        $user = User::where('email', 'f.rossignol@bds.coop')->first();
        $user->assignRolesToSites('Responsable Silo', [11, 15]);

        $user = User::where('email', 'y.joly@bds.coop')->first();
        $user->assignRolesToSites('Directeur Général Adjoint', $this->allSites);

        $user = User::where('email', 'b.combemorel@bds.coop')->first();
        $user->assignRolesToSites('Directeur Général', $this->allSites);

        $user = User::where('email', 'r.husmann@bds.coop')->first();
        $user->assignRolesToSites('Responsable Qualité', $this->allSites);

        $user = User::where('email', 'jl.fargere@bds.coop')->first();
        $user->assignRolesToSites('Responsable Maintenance', $this->allSitesExceptVerdunSiege);

        $user = User::where('email', 's.seraut@bds.coop')->first();
        $user->assignRolesToSites('Opérateur Maintenance', $this->allSitesExceptVerdunSiege);

        $user = User::where('email', 's.nnier@bds.coop')->first();
        $user->assignRolesToSites('Saisonnier Bourgogne du Sud', [6, 7, 21, 30]);

        $user = User::where('email', 'm.allain@bds.coop')->first();
        $user->assignRolesToSites('Responsable ValUnion', 51);

        $user = User::where('email', 'c.poncet@bds.coop')->first();
        $user->assignRolesToSites('Secrétaire', [3, 11]);
    }
}
