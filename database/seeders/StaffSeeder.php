<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('m_staffs')->truncate();
            $admin = Staff::factory()->admin()->create();
            $board_member = Staff::factory()->boardMember()->create();
            $director = Staff::factory()->director()->create();
            $deputy_director = Staff::factory()->deputyDirector()->create();
            $head_office = Staff::factory()->headOffice()->create();
            $general_manager = Staff::factory()->generalManager()->create();

            $qc_pass = 'qcpassword';
            $qc1 = Staff::factory()->dev('88881', $qc_pass)->create();
            $qc2 = Staff::factory()->dev('88882', $qc_pass)->create();
            $qc3 = Staff::factory()->dev('88883', $qc_pass)->create();

            $dev1 = Staff::factory()->dev('99991')->create();
            $dev2 = Staff::factory()->dev('99992')->create();
            $dev3 = Staff::factory()->dev('99993')->create();
            $dev4 = Staff::factory()->dev('99994')->create();
            $dev5 = Staff::factory()->dev('99995')->create();
            $dev6 = Staff::factory()->dev('99996')->create();
            $dev7 = Staff::factory()->dev('99997')->create();
            $dev8 = Staff::factory()->dev('99998')->create();
            $dev9 = Staff::factory()->dev('99999')->create();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
