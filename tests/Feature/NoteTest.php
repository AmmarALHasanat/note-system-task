<?php

namespace Tests\Feature;

use App\Http\Resources\NoteCollection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Note;
class NoteTest extends TestCase
{

    protected User $user;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user=User::first();
    }
    /** @test */
    public function user_auth_can_get_notes(): void
    {
        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $notes = $this->user->notes()->get();

        $response = $this->getNotes();

        $response->assertStatus(200)->assertJson([
            "data" => $notes->toArray()
        ]);
    }

    /** @test */
    public function user_unauth_can_get_notes(): void{
        $user = User::factory();
        $response = $this->getNotes();
        $response->assertStatus(401)->assertJson([
            "message" =>"Unauthenticated."
        ]);
    }

    /** @test */
    public function user_auth_can_show_note(): void{

        $note = Note::where('user_id',$this->user->id)->first();

        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        $response = $this->showNote($note->id);
        $response->assertStatus(200)->assertJson([
                "data" => $note->toArray()
            ]
        );
    }

    /** @test */
    public function user_auth_cant_show_note(): void{
        $note = Note::factory()->create();
        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        $response = $this->showNote($note->id);
        $response->assertStatus(400)->assertJson([
            "message"=> "You don't have permission to view this note",
            "success"=>false
            ]
        );
    }

    /** @test */
    public function user_auth_can_edit_note(): void{

        $note = Note::where('user_id',$this->user->id)->first();
        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response = $this->editNote($note->id,[
            'title'=>"test",
            'discrption'=>"test",
        ]);
        $response->assertStatus(200)->assertJson([
            "message"=> "Updated note successfully",
            "success"=> true
        ]);
    }

    /** @test */
    public function user_auth_cant_edit_note(): void{

        $note = Note::factory()->create();
        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response = $this->editNote($note->id,[
            'title'=>"test",
            'discrption'=>"test",
        ]);
        $response->assertStatus(400)->assertJson([
            "message"=> "You don't have permission to view this note",
            "success"=> false
        ]);
    }

    /** @test */
    public function user_auth_can_delete_note(): void{

        $note = Note::where('user_id',$this->user->id)->first();
        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response = $this->deleteNote($note->id);
        $response->assertStatus(200)->assertJson([
            "message"=> "Deleted note successfully",
            "success"=> true
        ]);
    }

    /** @test */
    public function user_auth_cant_delete_note(): void{

        $note = Note::factory()->create();
        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response = $this->deleteNote($note->id);
        $response->assertStatus(400)->assertJson([
            "message"=> "You don't have permission to view this note",
            "success"=> false
        ]);
    }


    /** @test */
    public function user_auth_can_crate_note(): void{

        $note = Note::where('user_id',$this->user->id)->first();
        $loginResponse = $this->login([
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response = $this->createNote([
            'title'=>"test",
            'discrption'=>"test",
        ]);
        $response->assertStatus(201)->assertJson([
            "message"=> "Cratered note successfully",
            "success"=> true
        ]);
    }
}
