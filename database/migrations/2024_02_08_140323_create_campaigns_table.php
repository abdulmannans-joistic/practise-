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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('campaign_name');
            $table->enum('campaign_status', ['active', 'inactive', 'completed']);
            $table->string('campaign_title')->nullable();
            $table->text('campaign_description')->nullable();
            $table->string('campaign_location')->nullable();
            $table->string('campaign_experience_req')->nullable();
            $table->string('campaign_pref_salary')->nullable();
            $table->string('campaign_document_url')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
};
