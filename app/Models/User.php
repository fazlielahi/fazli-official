<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable; // Makes the User model "authenticatable"
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPasswordNotification;
use App\Models\BulkMail\Campaign;
use App\Models\BulkMail\ContactList;
use App\Models\BulkMail\EmailTemplate;
use App\Models\BulkMail\Sender;
use App\Models\BulkMail\UserSubscription;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'photo', 'google_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    /**
     * Get all comments by this user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all CVs created by this user.
     */
    public function cvs()
    {
        return $this->hasMany(UserCV::class);
    }

    public function bulkMailSubscription()
    {
        return $this->hasOne(UserSubscription::class);
    }

    public function bulkMailSenders()
    {
        return $this->hasMany(Sender::class);
    }

    public function bulkMailContactLists()
    {
        return $this->hasMany(ContactList::class);
    }

    public function bulkMailEmailTemplates()
    {
        return $this->hasMany(EmailTemplate::class);
    }

    public function bulkMailCampaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
