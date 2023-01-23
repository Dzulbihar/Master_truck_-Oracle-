<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_email', function (Blueprint $table) {
            $table->id();

            $table->string('alamat_email_admin')->nullable();
            $table->string('nama_pengirim_admin')->nullable();

            $table->string('subjek_rfid_tag')->nullable();
            $table->string('header_rfid_tag')->nullable();
            $table->string('body_1_rfid_tag')->nullable();
            $table->string('body_2_rfid_tag')->nullable();
            $table->string('footer_rfid_tag')->nullable();

            $table->string('subjek_jadwal_ujian')->nullable();
            $table->string('header_jadwal_ujian')->nullable();
            $table->string('body_1_jadwal_ujian')->nullable();
            $table->string('body_2_jadwal_ujian')->nullable();
            $table->string('footer_jadwal_ujian')->nullable();

            $table->string('subjek_user_daftar')->nullable();
            $table->string('header_user_daftar')->nullable();
            $table->string('body_1_user_daftar')->nullable();
            $table->string('body_2_user_daftar')->nullable();
            $table->string('footer_user_daftar')->nullable();

            $table->string('subjek_user_aktif')->nullable();
            $table->string('header_user_aktif')->nullable();
            $table->string('body_1_user_aktif')->nullable();
            $table->string('body_2_user_aktif')->nullable();
            $table->string('footer_user_aktif')->nullable();

            $table->string('subjek_user_tidak_aktif')->nullable();
            $table->string('header_user_tidak_aktif')->nullable();
            $table->string('body_1_user_tidak_aktif')->nullable();
            $table->string('body_2_user_tidak_aktif')->nullable();
            $table->string('footer_user_tidak_aktif')->nullable();

            $table->string('subjek_user_block')->nullable();
            $table->string('header_user_block')->nullable();
            $table->string('body_1_user_block')->nullable();
            $table->string('body_2_user_block')->nullable();
            $table->string('footer_user_block')->nullable();

            $table->string('subjek_user_unblock')->nullable();
            $table->string('header_user_unblock')->nullable();
            $table->string('body_1_user_unblock')->nullable();
            $table->string('body_2_user_unblock')->nullable();
            $table->string('footer_user_unblock')->nullable();

//////////////////////////////////////////////////////////////////

            $table->string('subjek_truck_daftar')->nullable();
            $table->string('header_truck_daftar')->nullable();
            $table->string('body_1_truck_daftar')->nullable();
            $table->string('body_2_truck_daftar')->nullable();
            $table->string('footer_truck_daftar')->nullable();

            $table->string('subjek_truck_approve')->nullable();
            $table->string('header_truck_approve')->nullable();
            $table->string('body_1_truck_approve')->nullable();
            $table->string('body_2_truck_approve')->nullable();
            $table->string('footer_truck_approve')->nullable();

            $table->string('subjek_truck_reject')->nullable();
            $table->string('header_truck_reject')->nullable();
            $table->string('body_1_truck_reject')->nullable();
            $table->string('body_2_truck_reject')->nullable();
            $table->string('footer_truck_reject')->nullable();

            $table->string('subjek_truck_delete')->nullable();
            $table->string('header_truck_delete')->nullable();
            $table->string('body_1_truck_delete')->nullable();
            $table->string('body_2_truck_delete')->nullable();
            $table->string('footer_truck_delete')->nullable();

            $table->string('subjek_truck_block')->nullable();
            $table->string('header_truck_block')->nullable();
            $table->string('body_1_truck_block')->nullable();
            $table->string('body_2_truck_block')->nullable();
            $table->string('footer_truck_block')->nullable();

            $table->string('subjek_truck_unblock')->nullable();
            $table->string('header_truck_unblock')->nullable();
            $table->string('body_1_truck_unblock')->nullable();
            $table->string('body_2_truck_unblock')->nullable();
            $table->string('footer_truck_unblock')->nullable();

//////////////////////////////////////////////////////////////////

            $table->string('subjek_driver_daftar')->nullable();
            $table->string('header_driver_daftar')->nullable();
            $table->string('body_1_driver_daftar')->nullable();
            $table->string('body_2_driver_daftar')->nullable();
            $table->string('footer_driver_daftar')->nullable();

            $table->string('subjek_driver_approve')->nullable();
            $table->string('header_driver_approve')->nullable();
            $table->string('body_1_driver_approve')->nullable();
            $table->string('body_2_driver_approve')->nullable();
            $table->string('footer_driver_approve')->nullable();

            $table->string('subjek_driver_reject')->nullable();
            $table->string('header_driver_reject')->nullable();
            $table->string('body_1_driver_reject')->nullable();
            $table->string('body_2_driver_reject')->nullable();
            $table->string('footer_driver_reject')->nullable();

            $table->string('subjek_driver_delete')->nullable();
            $table->string('header_driver_delete')->nullable();
            $table->string('body_1_driver_delete')->nullable();
            $table->string('body_2_driver_delete')->nullable();
            $table->string('footer_driver_delete')->nullable();

            $table->string('subjek_driver_block')->nullable();
            $table->string('header_driver_block')->nullable();
            $table->string('body_1_driver_block')->nullable();
            $table->string('body_2_driver_block')->nullable();
            $table->string('footer_driver_block')->nullable();

            $table->string('subjek_driver_unblock')->nullable();
            $table->string('header_driver_unblock')->nullable();
            $table->string('body_1_driver_unblock')->nullable();
            $table->string('body_2_driver_unblock')->nullable();
            $table->string('footer_driver_unblock')->nullable();
            
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
        Schema::dropIfExists('ms_email');
    }
}
