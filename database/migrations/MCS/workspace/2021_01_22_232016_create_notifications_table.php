<?php

use Illuminate\Support\Arr;
use App\Enums\Rebase\MemberRoles;
use App\Enums\MCS\NotificationTypes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('workspace_id');
            $table->enum('type', Arr::flatten(NotificationTypes::toArray()));
            $table->string('message');
            $table->text('details')->nullable();
            $table->enum('visibility', Arr::flatten(MemberRoles::toArray()))->default(MemberRoles::MEMBER());
            $table->boolean('active')->default(false);
            $table->timestamps();

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
        Schema::dropIfExists('notifications');
    }
}
