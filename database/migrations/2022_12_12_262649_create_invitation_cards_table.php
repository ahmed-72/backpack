<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fixed_invitation_id')->constrained()->nullable();
            $table->foreignId('flexible_invitation_id')->constrained()->nullable();
            $table->foreignId('card_theme_id')->constrained();
            $table->longText('text');
            $table->longText('voice')->nullable();
            $table->longText('video')->nullable();
            $table->boolean('print_braille')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitation_cards');
    }
};
