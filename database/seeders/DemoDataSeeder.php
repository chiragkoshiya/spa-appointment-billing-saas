<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Room;
use App\Models\Staff;
use App\Models\User;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = User::first()->id ?? 1;

        // Seed Rooms
        $rooms = ['Room 101', 'Room 102', 'Room 103', 'VIP Suite'];
        foreach ($rooms as $room) {
            Room::updateOrCreate(['name' => $room], ['created_by' => $adminId, 'updated_by' => $adminId]);
        }

        // Seed Services (Therapies)
        $services = [
            ['name' => 'Full Body Massage', 'price' => 1500],
            ['name' => 'Deep Tissue Massage', 'price' => 2000],
            ['name' => 'Swedish Massage', 'price' => 1800],
            ['name' => 'Head & Shoulder Massage', 'price' => 800],
            ['name' => 'Foot Reflexology', 'price' => 600],
        ];
        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], [
                'price' => $service['price'],
                'created_by' => $adminId,
                'updated_by' => $adminId
            ]);
        }

        // Seed Staff
        $staff = ['Sita Kumari', 'Rita Devi', 'Anita Sharma', 'John Doe'];
        foreach ($staff as $name) {
            Staff::updateOrCreate(['name' => $name], [
                'phone' => '9876543210',
                'email' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'created_by' => $adminId,
                'updated_by' => $adminId
            ]);
        }

        // Seed Customers
        $customers = [
            ['name' => 'Abhisek Kumar', 'phone' => '1234567890'],
            ['name' => 'Rahul Singh', 'phone' => '9988776655'],
            ['name' => 'Priya Verma', 'phone' => '8877665544'],
        ];
        foreach ($customers as $customer) {
            Customer::updateOrCreate(['phone' => $customer['phone']], [
                'name' => $customer['name'],
                'customer_type' => 'normal',
                'created_by' => $adminId,
                'updated_by' => $adminId
            ]);
        }
    }
}
