<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Generator;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = app(Generator::class);

        $avatars = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        $user = factory(User::class)->times(10)->make()
                        ->each(function ($user, $index) use ($faker, $avatars) {
                            $user->avatar = $faker->randomElement($avatars);
                            $user->password = bcrypt('123456');
                        });
        $user_array = $user->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        $user = User::find(1);
        $user->name = 'Dennis';
        $user->avatar = 'http://larabbs.test/uploads/images/avatars/202001/16/1_15791171596Hiq0gbWu7.jpeg';
        $user->email = '123@qq.com';
        $user->password = bcrypt('123456');
        $user->save();

        $user->assignRole('Founder');

        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
