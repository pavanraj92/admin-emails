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
                [
                    'title' => 'Admin Login OTP',
                    'slug' => 'admin_login_otp',
                    'subject' => 'Your Admin Login OTP Code',
                    'description' => '<div style="max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="color:#333; margin-bottom:8px;">Two-Factor Authentication</h2>
                <p style="color:#666;">Use the verification code below to complete your login for <strong>%USER_EMAIL%</strong>.</p>
            </div>
            <div style="background: #f8f9fa; border-radius: 8px; padding: 30px; text-align: center; margin-bottom: 30px;">
                <h3 style="color: #333; margin-bottom: 20px; font-size: 18px;">Verification Code</h3>
                            <div style="background: #007bff; color: white; font-size: 32px; font-weight: bold; letter-spacing: 8px; padding: 20px; border-radius: 8px; display: inline-block; min-width: 240px;">
                    %OTP_CODE%
                </div>
                <p style="color: #666; margin-top: 15px; font-size: 14px;">
                    This code will expire in <strong>5 minutes</strong>.
                </p>
            </div>
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <p style="color: #856404; margin: 0; font-size: 14px;">
                    <strong>Security Notice:</strong> If you didn\'t request this code, please ignore this email and consider changing your password.
                </p>
            </div>
        </div>

        <div style="text-align: center; color: #666; font-size: 14px;">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>For security reasons, this code can only be used once and will expire in 5 minutes.</p>
        </div>
        </div>
        <p>%EMAIL_FOOTER%</p>',
        
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