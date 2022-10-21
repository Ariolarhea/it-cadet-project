<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_id');
            $table->string('path');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
