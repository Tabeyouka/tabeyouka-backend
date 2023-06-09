<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LocalSemesterComments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalSemesterCommentsTest extends TestCase
{

    use RefreshDatabase;

    public function test_get_comments_successfully()
    {
        $lsComments = LocalSemesterComments::factory()->create();

        $response = $this->getJson("/api/localsemestercomments");

        $response->assertStatus(200)->assertJson([
            ['id'=> $lsComments->id,
            'author_id'=>$lsComments->author_id,
            'comment_text'=>$lsComments->comment_text,]
        ]);
    }

    public function test_add_comment_successfully()
    {
        $user = User::factory()->create();
        $data = LocalSemesterComments::factory()->create();

        $response = $this->actingAs($user)->postJson("/api/localsemestercomments",$data->toArray());

        $response->assertStatus(200)->assertJson(['message' => 'Add comment successfully']);
    }

    public function test_edit_comment_successfully()
    {   
        $user = User::factory()->create();

        $lsComments = LocalSemesterComments::factory()->create();

        $response = $this->actingAs($user)->patchJson("/api/localsemestercomments",$lsComments->toArray());

        $response->assertStatus(200)->assertJson(['message' => 'Edit comment successfully']);
    }

    public function test_delete_comment_successfully()
    {
        $user = User::factory()->create();

        $lsComments = LocalSemesterComments::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/api/localsemestercomments/{$lsComments->id}");

        $response->assertStatus(200)->assertJson(['message' => 'Delete comment successfully']);
    }
}
