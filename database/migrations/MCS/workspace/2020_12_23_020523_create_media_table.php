<?php

use Illuminate\Support\Arr;
use App\Enums\MCS\MediaTypes;
use App\Enums\Rebase\MemberRoles;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workspace_id');
            $table->string('name');
            $table->string('path');
            $table->string('url');
            $table->enum('type', Arr::flatten(MediaTypes::toArray()));
            $table->enum('visibility', Arr::flatten(MemberRoles::toArray()))->default(MemberRoles::MEMBER());
            $table->boolean('archive')->default(false);
            $table->timestamps();

            $table->unique(['workspace_id', 'name']);

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
        Schema::dropIfExists('media');
    }
}
