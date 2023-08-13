<?php

namespace Database\Factories;

use App\Models\Pc;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PcFactory extends Factory
{
    protected $model = Pc::class;

    public function definition(): array
    {
        $protocol = $this->faker->randomElement(['http', 'https', 'tcp', 'udp']);
        $port = $this->faker->numberBetween(1, 65535);
        $ipv4 = $this->faker->ipv4();
        $url = $protocol.'://'.$ipv4.':'.$port;

        return [
            'name' => $this->faker->name(),
            'url' => $url,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
