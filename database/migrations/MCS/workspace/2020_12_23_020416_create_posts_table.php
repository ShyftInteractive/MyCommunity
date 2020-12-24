<?php

use Illuminate\Support\Arr;
use App\Enums\Rebase\MemberRoles;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workspace_id');
            $table->uuid('member_id');
            $table->string('slug');
            $table->string('title');
            $table->string('feature_image')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->enum('visibility', Arr::flatten(MemberRoles::toArray()))->default(MemberRoles::PUBLIC_ACCESS());
            $table->timestamp('featured_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['workspace_id', 'slug']);

            $table->foreign('member_id')
                ->references('id')
                ->on('members')
                ->onDelete('cascade');

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
        Schema::dropIfExists('posts');
    }
}
