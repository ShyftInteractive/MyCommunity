<?php

use Illuminate\Support\Arr;
use App\Enums\Rebase\MemberRoles;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workspace_id');
            $table->string('slug', 100);
            $table->string('path')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('content')->nullable();
            $table->enum('visibility', Arr::flatten(MemberRoles::toArray()))->default(MemberRoles::PUBLIC_ACCESS());
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['workspace_id', 'slug']);

            $table->foreign('workspace_id')
                ->references('id')
                ->on('workspaces')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
