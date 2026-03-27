<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Models\Order;

class TestGmail extends Command
{
    protected $signature = 'email:test-gmail';
    protected $description = 'Test Gmail SMTP configuration';

    public function handle()
    {
        $this->info('Testing Gmail SMTP configuration...');
        
        try {
            // Create a test order with all required fields
            $order = new Order([
                'order_number' => 'TEST-' . time(),
                'user_id' => 1,
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
                'discount' => 0,
                'shipping_cost' => 15,
                'total' => 125,
                'payment_method' => 'test',
                'payment_status' => 'completed',
                'delivery_method' => 'standard',
                'delivery_status' => 'processing',
                'notes' => 'Test order',
                'ip_address' => '127.0.0.1',
                'status' => 'processing',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Create a mock order item
            $orderItem = new \stdClass();
            $orderItem->name = 'Test Product';
            $orderItem->price = 100;
            $orderItem->quantity = 1;
            $orderItem->total = 100;
            $orderItem->image_url = 'https://via.placeholder.com/100';
            $orderItem->options = [];
            
            // Set the items relation
            $order->setRelation('items', collect([$orderItem]));
            
            // Set the user relation
            $order->user = (object)[
                'name' => 'Test User',
                'email' => env('MAIL_FROM_ADDRESS')
            ];
            
            // Add a created_at accessor if needed
            $order->created_at = now();
            
            // Debug: Dump the order to check its structure
            // dd($order);
            
            // Send a simple test email first to verify SMTP
            $this->info('Sending a simple test email...');
            \Illuminate\Support\Facades\Mail::raw('This is a test email from FruitMart', function($message) {
                $message->to(env('MAIL_FROM_ADDRESS'))
                        ->subject('FruitMart: Test Email');
            });
            
            $this->info('✅ Simple test email sent successfully!');
            
            // Now try sending the order confirmation
            $this->info('Sending order confirmation email...');
            Mail::to(env('MAIL_FROM_ADDRESS'))
                ->send(new OrderConfirmation($order));
                
            $this->info('✅ Order confirmation email sent successfully!');
            $this->info('Check your email (including spam folder).');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Error sending email:');
            $this->line($e->getMessage());
            $this->line('');
            $this->line('🔧 Troubleshooting:');
            $this->line('1. Make sure 2-Step Verification is enabled');
            $this->line('2. Create an App Password at: https://myaccount.google.com/apppasswords');
            $this->line('3. Verify your .env file has correct values:');
            $this->line('   MAIL_MAILER=smtp');
            $this->line('   MAIL_HOST=smtp.gmail.com');
            $this->line('   MAIL_PORT=587');
            $this->line('   MAIL_USERNAME=your-email@gmail.com');
            $this->line('   MAIL_PASSWORD=your-app-password');
            $this->line('   MAIL_ENCRYPTION=tls');
            $this->line('   MAIL_FROM_ADDRESS=your-email@gmail.com');
            $this->line('   MAIL_FROM_NAME="FruitMart"');
            return 1;
        }
    }
}
