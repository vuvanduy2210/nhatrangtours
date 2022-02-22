<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $api_token1 = Str::random(64);
        $api_token2 = Str::random(64);
        $api_token3 = Str::random(64);

        $referral_code1 = Str::random(16);
        $referral_code2 = Str::random(16);
        $referral_code3 = Str::random(16);

        $array = [
            ['fullname' => 'Vũ Văn Duy', 'username' => 'duycute', 'email' => 'duy@gmail.com', 'link_img' => 'default.png',
                'phone' => '03336999', 'role' => '1', 'api_token' => $api_token2,
                'qr_code' => QrCode::size(300)->generate(app()->url('/') . '?referral_code=' . $referral_code1),
                'referral_code' => $referral_code1
                ],

            ['fullname' => 'Kien Le Van', 'username' => 'kienlevan', 'email' => 'kienlevan@gmail.com', 'link_img' => 'default.png',
                'phone' => '033369999', 'role' => '1', 'api_token' => $api_token1, 'qr_code' => QrCode::size(300)->generate(app()->url('/') . '?referral_code=' . $referral_code2),
                'referral_code' => $referral_code2],

            ['fullname' => 'Vũ Duy', 'username' => 'duyduy', 'email' => 'duy123@gmail.com', 'link_img' => 'default.png',
                'phone' => '0333699', 'role' => '0', 'api_token' => $api_token3, 'qr_code' => QrCode::size(300)->generate(app()->url('/') . '?referral_code=' . $referral_code3),
                'referral_code' => $referral_code3],

        ];

        Db::table('users')->insert($array);
    }
}
