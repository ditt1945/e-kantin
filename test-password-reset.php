<?php

/**
 * Test Script for Password Reset Functionality
 * Run this script to test if email configuration is working
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Password;

echo "=== Password Reset Testing Script ===\n\n";

// 1. Check if user exists
echo "1. Checking existing users...\n";
$users = User::all();
echo "Total users: " . $users->count() . "\n\n";

if ($users->count() === 0) {
    echo "No users found. Creating test user...\n";
    User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password')
    ]);
    echo "Test user created successfully!\n\n";
}

// 2. Test password reset token generation
echo "2. Testing password reset token generation...\n";
$user = User::first();
if ($user) {
    echo "Testing with user: " . $user->name . " (" . $user->email . ")\n";

    try {
        // Generate password reset token
        $token = Password::createToken($user);
        echo "✓ Password reset token generated: " . substr($token, 0, 20) . "...\n";

        // Test if token is valid
        $credentials = [
            'email' => $user->email,
            'token' => $token,
        ];

        $userFromToken = Password::getUser($credentials);
        if ($userFromToken && $userFromToken->email === $user->email) {
            echo "✓ Token validation successful\n";
        } else {
            echo "✗ Token validation failed\n";
        }

        // Generate password reset URL
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));
        echo "✓ Reset URL: " . $resetUrl . "\n";

    } catch (Exception $e) {
        echo "✗ Error generating token: " . $e->getMessage() . "\n";
    }
} else {
    echo "✗ No user found for testing\n";
}

echo "\n3. Testing email configuration...\n";

// Check mail configuration
$mailConfig = config('mail');
echo "Mail driver: " . $mailConfig['default'] . "\n";
echo "Mail host: " . $mailConfig['mailers'][$mailConfig['default']]['host'] . "\n";
echo "Mail port: " . $mailConfig['mailers'][$mailConfig['default']]['port'] . "\n";

echo "\n4. Instructions for testing:\n";
echo "- Start Mailpit: mailpit\n";
echo "- Open http://127.0.0.1:8025 in browser\n";
echo "- Visit: http://127.0.0.1:8000/forgot-password\n";
echo "- Enter user email and submit\n";
echo "- Check Mailpit interface for the reset email\n";

echo "\n=== Test Complete ===\n";