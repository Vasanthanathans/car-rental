<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name', 200);
            $table->string('admin_email', 200);
            $table->string('meta_title', 500);
            $table->string('meta_description', 500);
            $table->string('meta_keywords', 500);
            $table->string('site_logo', 100);
            $table->string('footer_logo', 100);
            $table->string('fav_icon', 100);
            $table->string('fb_app_id', 100);
            $table->string('fb_app_secret', 100);
            $table->text('fb_access_token');
            $table->string('twitter_app_id', 100);
            $table->string('twitter_name', 100);
            $table->text('copy_right');
            $table->string('gmail_client_id', 200);
            $table->string('gmail_client_secret', 200);
            $table->string('gmail_redirect_url', 500);
            $table->string('gmap_key', 500);
            $table->string('facebook_link', 200);
            $table->string('twitter_link', 200);
            $table->string('linkedin_link', 200);
            $table->string('instagram_link', 200);
            $table->string('youtube_link', 200);
            $table->text('google_data_studio_link');
            $table->text('google_analytics');
            $table->string('twillio_account_sid', 500);
            $table->string('twillio_auth_token', 500);
            $table->string('twillio_number', 200);
            $table->string('twillio_mode', 200);
            $table->string('paypal_email', 200);
            $table->enum('paypal_mode', [0, 1])->default(0);
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
        Schema::dropIfExists('admin_settings');
    }
}
