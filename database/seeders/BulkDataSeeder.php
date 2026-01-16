<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Room;
use App\Models\Staff;
use App\Models\User;
use App\Models\Offer;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\MemberWallet;
use App\Models\StaffDocument;
use App\Models\Role;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BulkDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Ensure Roles exist
        $roles = ['Super Admin', 'Admin', 'Manager', 'Receptionist', 'Staff'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
        
        $roleIds = Role::pluck('id')->toArray();
        $adminId = User::first()->id ?? 1;

        // 1. Users (30 entries)
        $this->command->info('Seeding Users...');
        for ($i = 0; $i < 30; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => 'password',
                'role_id' => $faker->randomElement($roleIds),
                'is_active' => true,
            ]);
        }
        $userIds = User::pluck('id')->toArray();

        // 2. Customers (50 entries)
        $this->command->info('Seeding Customers...');
        for ($i = 0; $i < 50; $i++) {
            $user = $faker->randomElement($userIds);
            $customer = Customer::create([
                'name' => $faker->name,
                'phone' => substr($faker->unique()->phoneNumber, 0, 15),
                'email' => $faker->safeEmail,
                'customer_type' => $faker->randomElement(['normal', 'member']),
                'created_by' => $user,
                'updated_by' => $user,
            ]);

            if ($customer->customer_type == 'member') {
                MemberWallet::create([
                    'customer_id' => $customer->id,
                    'balance' => $faker->randomFloat(2, 500, 10000),
                    'created_by' => $user,
                    'updated_by' => $user,
                ]);
            }
        }
        $customerIds = Customer::pluck('id')->toArray();

        // 3. Staff (30 entries)
        $this->command->info('Seeding Staff...');
        for ($i = 0; $i < 30; $i++) {
            $user = $faker->randomElement($userIds);
            $staff = Staff::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => substr($faker->unique()->phoneNumber, 0, 15),
                'address' => $faker->address,
                'is_active' => true,
                'created_by' => $user,
                'updated_by' => $user,
            ]);

            StaffDocument::create([
                'staff_id' => $staff->id,
                'document_type' => $faker->randomElement(['ID Proof', 'Contract', 'Passport']),
                'file_path' => 'documents/dummy.pdf',
                'created_by' => $user,
                'updated_by' => $user,
            ]);
        }
        $staffIds = Staff::pluck('id')->toArray();

        // 4. Rooms (30 entries)
        $this->command->info('Seeding Rooms...');
        for ($i = 0; $i < 30; $i++) {
            $user = $faker->randomElement($userIds);
            $name = "Room " . ($i + 101) . " " . $faker->word;
            Room::create([
                'name' => $name,
                'slug' => Str::slug($name . '-' . Str::random(5)),
                'is_active' => true,
                'created_by' => $user,
                'updated_by' => $user,
            ]);
        }
        $roomIds = Room::pluck('id')->toArray();

        // 5. Services (30 entries)
        $this->command->info('Seeding Services...');
        $servicesList = [
            'Thai Massage', 'Oil Massage', 'Full Body Wrap', 'Face Cleansing', 'Manicure', 
            'Pedicure', 'Sauna Session', 'Steam Bath', 'Deep Tissue', 'Swedish Therapy',
            'Hot Stone', 'Aromatherapy', 'Ayurvedic Massage', 'Sports Massage', 'Shiatsu',
            'Reflexology', 'Scrubbing', 'Mud Bath', 'Hydrotherapy', 'Facial Mask',
            'Nail Art', 'Hair Spa', 'Head Massage', 'Back Massage', 'Leg Massage',
            'Couples Massage', 'Prenatal Massage', 'Lomi Lomi', 'Thai Foot Spa', 'Balinese Massage'
        ];
        
        foreach ($servicesList as $serviceName) {
            $user = $faker->randomElement($userIds);
            Service::create([
                'name' => $serviceName,
                'price' => $faker->randomFloat(2, 500, 5000),
                'duration_minutes' => $faker->randomElement([30, 60, 90, 120]),
                'is_active' => true,
                'created_by' => $user,
                'updated_by' => $user,
            ]);
        }
        $serviceIds = Service::pluck('id')->toArray();

        // 6. Offers (30 entries)
        $this->command->info('Seeding Offers...');
        for ($i = 0; $i < 30; $i++) {
            $user = $faker->randomElement($userIds);
            $discountType = $faker->randomElement(['percentage', 'flat']);
            Offer::create([
                'name' => $faker->word . ' Offer ' . ($i + 1),
                'discount_type' => $discountType,
                'discount_value' => ($discountType == 'percentage') ? $faker->numberBetween(5, 50) : $faker->numberBetween(100, 500),
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(30),
                'is_active' => true,
                'created_by' => $user,
                'updated_by' => $user,
            ]);
        }
        $offerIds = Offer::pluck('id')->toArray();

        // 7. Inventory Items (30 entries)
        $this->command->info('Seeding Inventory...');
        $inventoryList = [
            'Lavender Oil', 'Coconut Oil', 'Massage Cream', 'Towels', 'Face Masks',
            'Shampoo', 'Conditioner', 'Scrub Gel', 'Linen Sheets', 'Disinfectant',
            'Slippers', 'Bathrobes', 'Aroma Diffuser', 'Candles', 'Incense Stick',
            'Herbal Tea', 'Cotton Balls', 'Sponges', 'Nail Polish', 'Acetone',
            'Hair Dryer', 'Bedsheets', 'Curtains', 'Hand Wash', 'Body Wash',
            'Moisturizer', 'Sunscreen', 'Foot Cream', 'Eye Pads', 'Cleansing Milk'
        ];

        foreach ($inventoryList as $itemName) {
            $user = $faker->randomElement($userIds);
            $item = InventoryItem::create([
                'name' => $itemName,
                'quantity' => $faker->numberBetween(10, 100),
                'amount' => $faker->randomFloat(2, 50, 1000),
                'created_by' => $user,
                'updated_by' => $user,
            ]);

            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'user_id' => $user,
                'change_qty' => $item->quantity,
                'reason' => 'Initial bulk seed',
                'created_by' => $user,
                'updated_by' => $user,
            ]);
        }

        // 8. Appointments & Invoices (50 entries)
        $this->command->info('Seeding Appointments and Invoices...');
        for ($i = 0; $i < 50; $i++) {
            $user = $faker->randomElement($userIds);
            $service = Service::find($faker->randomElement($serviceIds));
            $customer = Customer::find($faker->randomElement($customerIds));
            
            $startTime = $faker->dateTimeBetween('now', '+1 month')->format('H:i');
            $date = $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d');
            $duration = $service->duration_minutes;
            $endTime = date('H:i', strtotime($startTime . " + $duration minutes"));

            $appointment = Appointment::create([
                'customer_id' => $customer->id,
                'phone' => substr($customer->phone, 0, 15),
                'staff_id' => $faker->randomElement($staffIds),
                'room_id' => $faker->randomElement($roomIds),
                'service_id' => $service->id,
                'appointment_date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'duration' => $duration,
                'status' => $faker->randomElement(['created', 'completed']),
                'is_member' => ($customer->customer_type == 'member'),
                'payment_method' => $faker->randomElement(['cash', 'card', 'upi', 'wallet']),
                'amount' => $service->price,
                'payment_status' => $faker->randomElement(['pending', 'paid']),
                'created_by' => $user,
                'updated_by' => $user,
            ]);

            AppointmentService::create([
                'appointment_id' => $appointment->id,
                'service_id' => $service->id,
                'price' => $service->price,
                'created_by' => $user,
                'updated_by' => $user,
            ]);

            if ($appointment->status == 'completed') {
                $invoice = Invoice::create([
                    'appointment_id' => $appointment->id,
                    'customer_id' => $appointment->customer_id,
                    'total_amount' => $appointment->amount,
                    'wallet_deduction' => 0,
                    'payable_amount' => $appointment->amount,
                    'payment_mode' => $faker->randomElement(['cash', 'online']),
                    'created_by' => $user,
                    'updated_by' => $user,
                ]);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $service->name,
                    'amount' => $service->price,
                    'created_by' => $user,
                    'updated_by' => $user,
                ]);
            }
        }

        $this->command->info('Bulk data seeding completed successfully!');
    }
}
