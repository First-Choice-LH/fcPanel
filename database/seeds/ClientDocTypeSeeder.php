<?php

use Illuminate\Database\Seeder;
use App\ClientDocType;

class ClientDocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentTypes      = ['Company Credit Application Form', 'Schedule Of Rates',
                                'Terms of Business (Signed)', 'Other Documents'
        ];

        foreach($documentTypes as $type) {
            ClientDocType::create(['type' => $type]);
        }

    }
}
