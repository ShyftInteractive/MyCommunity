<?php

use Illuminate\Support\Arr;
use App\Enums\Rebase\MemberRoles;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workspace_id');
            $table->string('name')->nullable();
            $table->string('path');
            $table->enum('visibility', Arr::flatten(MemberRoles::toArray()))->default(MemberRoles::MEMBER());
            $table->boolean('archive', false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
