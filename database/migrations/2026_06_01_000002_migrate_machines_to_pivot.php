<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing machine-page relationships to pivot table
        $machines = DB::table('machines')->whereNotNull('page')->get();
        
        foreach ($machines as $machine) {
            $page = DB::table('pages')->where('slug', $machine->page)->first();
            
            if ($page) {
                DB::table('page_machines')->insertOrIgnore([
                    'page_id' => $page->id,
                    'machine_id' => $machine->id,
                    'position' => $machine->order ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Migrate card-page relationships
        $cards = DB::table('cards')->whereNotNull('page')->get();
        
        foreach ($cards as $card) {
            $page = DB::table('pages')->where('slug', $card->page)->first();
            
            if ($page) {
                DB::table('cards')->where('id', $card->id)->update(['page_id' => $page->id]);
            }
        }
    }

    public function down(): void
    {
        DB::table('page_machines')->truncate();
        DB::table('cards')->update(['page_id' => null]);
    }
};
