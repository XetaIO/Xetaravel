<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussConversationsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $conversations = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'This is an announcement.',
                'slug' => 'this-is-an-announcement',
                'user_count' => 2,
                'post_count' => 2,
                'is_locked' => true,
                'is_pinned' => false,
                'is_solved' => false,
                'is_edited' => false,
                'first_post_id' => null,
                'solved_post_id' => null,
                'last_post_id' => null,
                'edited_user_id' => null,
                'edited_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('discuss_conversations')->insert($conversations);

        // Update the foreign key related to conversations.
        DB::table('discuss_categories')
            ->where('id', 1)
            ->update([
                'last_conversation_id' => 1
            ]);
    }
}
