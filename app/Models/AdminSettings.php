<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_name',
        'admin_email',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'site_logo',
        'footer_logo',
        'fav_icon',
        'fb_app_id',
        'fb_app_secret',
        'fb_access_token',
        'twitter_app_id',
        'twitter_name',
        'copy_right',
        'gmail_client_id',
        'gmail_client_secret',
        'gmail_redirect_url',
        'gmap_key',
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'instagram_link',
        'youtube_link',
        'google_data_studio_link',
        'google_analytics',
        'twillio_account_sid',
        'twillio_auth_token',
        'twillio_number',
        'twillio_mode',
        'paypal_email',
        'paypal_mode',
    ];
}
