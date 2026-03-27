<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\User;

class TestRealEmail extends Command
{
    protected $signature = 'email:test-real';
    protected $description = 'Send a test email using real SMTP settings';

    public function handle()
    {
        $this->info('Sending test email...');

        try {
            // Create a test order or use an existing one
            $order = Order::first();
            
            if (!$order) {
                // Create a dummy order for testing if none exists
                $order = new Order([
                    'order_number' => 'TEST-' . time(),
                    'user_id' => User::first()?->id ?? 1,
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => env('MAIL_FROM_ADDRESS'),
                    'phone' => '1234567890',
                    'address' => '123 Test St',
                    'city' => 'Test City',
                    'postal_code' => '12345',
                    'country' => 'Test Country',
                    'subtotal' => 100,
                    'tax' => 10,
                    'shipping_cost' => 15,
                    'total' => 125,
                    'payment_method' => 'test',
                    'payment_status' => 'completed',
                    'status' => 'processing'
                ]);
                $order->save();
            }

            // Send the email
            Mail::to(env('MAIL_FROM_ADDRESS'))
                ->send(new OrderConfirmation($order));

            $this->info('Test email sent successfully to ' . env('MAIL_FROM_ADDRESS'));
            $this->info('Check your inbox (and spam folder) for the test email.');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('Error sending email: ' . $e->getMessage());
            $this->error('Make sure you\'ve:');
            $this->line('- Enabled 2-Step Verification');
            $this->line('- Created an App Password for your Gmail account');
            $this->line('- Updated your .env file with the correct credentials');
            
            return Command::FAILURE;
        }
    }
}
