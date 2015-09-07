<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Village\Entities\Building;
use Modules\Village\Entities\User;
use Modules\Village\Entities\Token;
use Modules\Village\Entities\Article;

use Modules\Village\Entities\ServiceCategory;
use Modules\Village\Entities\Service;
use Modules\Village\Entities\ServiceOrder;

use Modules\Village\Entities\ProductCategory;
use Modules\Village\Entities\Product;
use Modules\Village\Entities\ProductOrder;

use Modules\Village\Entities\Survey;
use Modules\Village\Entities\SurveyVote;

use Modules\Village\Entities\Option;
use Modules\Village\Entities\Margin;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker\Factory::create();

		Building::create([
			'address' => $faker->unique()->address,
			'code' => str_random(10),
		]);


		User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone' => $faker->unique()->phoneNumber,
            'password' => Hash::make($faker->password),
            'building_id' => $faker->randomElement($this->getItems('village__buildings')),
		]);


		Token::create([
			'code' => str_random(10),
			'phone' => $faker->phoneNumber,
			'type' => 'CREATE'
		]);


		Article::create([
			'title' => $faker->sentence(3),
			'text' => $faker->text,
			'short' => $faker->text(100)
		]);


		ServiceCategory::create([
			'title' => $faker->unique()->sentence(3),
			'order' => 0
		]);


		Service::create([
			'service_category_id' => $faker->randomElement($this->getItems('village__servicecategories')),
			'title' => $faker->unique()->sentence(3),
			'price' => $faker->randomFloat(4, 0)
		]);


		ServiceOrder::create([
			'service_id' => $faker->randomElement($this->getItems('village__services')),
			'dateTime' => $faker->dateTime('now'),
			'price' => $faker->randomFloat(4, 0),
			'status' => 'IN PROGRESS'
		]);


		ProductCategory::create([
			'title' => str_random(10),
			'order' => 0
		]);


		Product::create([
			'product_category_id' => $faker->randomElement($this->getItems('village__productcategories')),
			'title' => $faker->unique()->sentence(3),
			'price' => $faker->randomFloat(4, 0),
			'image' => $faker->imageUrl(640, 480)
		]);


		ProductOrder::create([
			'product_id' => $faker->randomElement($this->getItems('village__products')),
			'user_id' => $faker->randomElement($this->getItems('village__users')),
			'dateTime' => $faker->dateTime('now'),
			'price' => $faker->randomFloat(4, 0),
			'quantity' => $faker->randomDigit,
			'comment' => $faker->text,
			'status' => 'IN PROGRESS'
		]);

		Survey::create([
			'title' => $faker->sentence(3),
			'options' => json_encode(array('Yes', 'No', 'Maybe')),
			'endsAt' => $faker->dateTime('now')
		]);


		SurveyVote::create([
			'user_id' => $faker->randomElement($this->getItems('village__users')),
			'survey_id' => $faker->randomElement($this->getItems('village__surveys')),
			'choice' => $faker->randomElement(array(0, 1, 2))
		]);


		Option::create([
			'key' => $faker->word,
			'value' => $faker->sentence(3)
		]);


		Margin::create([
			'type' => $faker->randomElement(['PERCENT', 'CASH']),
			'value' => $faker->randomFloat(3, 0)
		]);
    }

    static function getItems($table) {
    	$items = DB::table($table)->lists('id');
    	return $items;
    }
}
