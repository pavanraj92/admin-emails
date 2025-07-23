<?php

namespace Admin\Emails\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MailDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example: Seed emails table
        if (Schema::hasTable('emails')) {
            $templates = [
                [
                    'title' => 'Welcome Email',
                    'slug' => 'welcome_email',
                    'subject' => 'Welcome to %APP_NAME%!',
                    'description' => '<p>Dear %USER_NAME%,</p>

<p>Welcome to <strong>%APP_NAME%</strong>! We are delighted to have you join our community. Your registration is now complete, and you can start exploring all the features and benefits we offer.</p>

<p>If you have any questions or need assistance, our support team is always here to help. We look forward to supporting your success!</p>

<p>Best regards,<br />
The %APP_NAME% Team<br />
%EMAIL_FOOTER%</p>
',                    
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Register user',
                    'slug' => 'register_user',
                    'subject' => 'Welcome to %APP_NAME%!',
                    'description' => '<p>Dear %USER_NAME%,</p>

<p>Thank you for registering with <strong>%APP_NAME%</strong>. Your account has been successfully created, and you now have access to our Quotation Management System.</p>

<p>Below are your login credentials. Please keep them secure and do not share them with anyone.</p>

<p><strong>Login Credentials:</strong></p>
<p>Email Address: %EMAIL_ADDRESS%<br />
Password: %PASSWORD%</p>

<p>If you have any questions or require assistance, please contact our support team.</p>

<p>We wish you a productive experience!</p>

<p>Best regards,<br />
The %APP_NAME% Team<br />
%EMAIL_FOOTER%</p>
',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Register admin',
                    'slug' => 'register_admin',
                    'subject' => 'Welcome to %APP_NAME%!',
                    'description' => '<p>Dear %ADMIN_NAME%,</p>

<p>Thank you for registering with <strong>%APP_NAME%</strong>. Your account has been successfully created, and you now have access to our Quotation Management System.</p>

<p>Below are your login credentials. Please keep them secure and do not share them with anyone.</p>

<p><strong>Login Credentials:</strong></p>
<p>Email Address: %EMAIL_ADDRESS%<br />
Password: %PASSWORD%</p>

<p>If you have any questions or require assistance, please contact our support team.</p>

<p>We wish you a productive experience!</p>

<p>Best regards,<br />
The %APP_NAME% Team<br />
%EMAIL_FOOTER%</p>
',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Password Reset',
                    'slug' => 'password_reset',
                    'subject' => 'Password Reset Request',
                    'description' => '<p>Dear %USER_NAME%,</p>

<p>We received a request to reset your password for your <strong>%APP_NAME%</strong> account. To proceed, please click the link below:</p>

<p>%RESET_LINK%</p>

<p>If you did not request a password reset, please ignore this email or contact our support team immediately.</p>

<p>Best regards,<br />
The %APP_NAME% Team<br />
%EMAIL_FOOTER%</p>
',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Email Verification',
                    'slug' => 'email_verification',
                    'subject' => 'Verify Your Email Address',
                    'description' => '<p>Dear %USER_NAME%,</p>

<p>Thank you for registering with <strong>%APP_NAME%</strong>. To complete your registration, please verify your email address by clicking the link below:</p>

<p>%VERIFICATION_LINK%</p>

<p>If you did not create this account, please disregard this email.</p>

<p>Best regards,<br />
The %APP_NAME% Team<br />
%EMAIL_FOOTER%</p>
',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];
            foreach ($templates as $template) {
                $exists = DB::table('emails')->where('slug', $template['slug'])->exists();
                if (!$exists) {
                    DB::table('emails')->insert($template);
                }
            }
        }
    }
}
