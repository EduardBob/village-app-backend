<?php

use Illuminate\Database\Seeder;

use Modules\User\Entities\Sentinel\User;

use Modules\Village\Entities\Building;
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


	    for($i=0; $i < 100; $i++) {
		    Building::create([
			    'address' => $faker->unique()->address,
			    'code' => str_random(10),
		    ]);
	    }
	    $buildings = $this->getItems(Modules\Village\Entities\Building::class);


	    for($i=0; $i < 100; $i++) {
		    try {
			    $user = (new User)->fill([
				    'email' => $faker->unique()->email,
				    'password' => $faker->password,
				    'permissions' => [],
				    'first_name' => $faker->firstName,
				    'last_name' => $faker->lastName,
				    'phone' => $faker->unique()->phoneNumber,
				    'building_id' => $faker->randomElement($buildings),
//				    'activated' => $faker->randomElement([0, 1])
			    ]);
			    $user->save();
		    }
		    catch (\Exception $e) {var_dump($e);die;}
	    }
	    $users = $this->getItems(User::class);

		Token::create([
			'code' => str_random(10),
			'phone' => $faker->phoneNumber,
			'type' => $faker->randomElement((new Token)->getTypes()),
		]);


	    for($i=0; $i < 100; $i++) {
		    Article::create([
			    'title' => $faker->sentence(3),
			    'text' => $faker->text(1000),
			    'created_at' => $createdAt = $faker->dateTimeBetween('-10 year'),
			    'updated_at' => $faker->dateTimeBetween($createdAt),
			    'active' => $faker->randomElement([0, 1]),
		    ]);
	    }


	    for($i=0; $i < 20; $i++) {
		    ServiceCategory::create([
			    'title' => $faker->unique()->sentence(3),
			    'active' => $faker->randomElement([0, 1]),
			    'order' => 0
		    ]);
	    }
	    $serviceCategories = $this->getItems(Modules\Village\Entities\ServiceCategory::class);

	    for($i=0; $i < 50; $i++) {
		    Service::create([
			    'category_id' => $faker->randomElement($serviceCategories),
			    'title' => $faker->unique()->sentence(3),
			    'price' => $faker->randomFloat(4, 0, 1000),
			    'active' => $faker->randomElement([0, 1]),
		    ]);
	    }
	    $services = $this->getItems(Modules\Village\Entities\Service::class);

	    for($i=0; $i < 50; $i++) {
		    try {
			    ServiceOrder::create([
				    'service_id' => $faker->randomElement($services),
				    'user_id' => $faker->randomElement($users),
				    'perform_at' => $faker->dateTimeBetween('-5 years'),
				    'status' => $status = $faker->randomElement(config('village.order.statuses')),
				    'comment' => $faker->randomElement([0, 1]) ? $faker->text : null,
				    'decline_reason' => $status == 'rejected' ? $faker->text() : null,
			    ]);
		    }
			catch (\Exception $e) {}
	    }

	    for($i=0; $i < 30; $i++) {
		    ProductCategory::create([
			    'title' => str_random(10),
			    'active' => $faker->randomElement([0, 1]),
			    'order' => 0,
		    ]);
	    }
	    $productCategories = $this->getItems(Modules\Village\Entities\ProductCategory::class);

	    for($i=0; $i < 50; $i++) {
		    Product::create([
			    'category_id' => $faker->randomElement($productCategories),
			    'title' => $faker->unique()->sentence(3),
			    'price' => $faker->randomFloat(4, 0),
			    'image' => $faker->imageUrl(640, 480),
			    'active' => $faker->randomElement([0, 1]),
		    ]);
	    }
	    $products = $this->getItems(Modules\Village\Entities\Product::class);

	    for($i=0; $i < 50; $i++) {
		    ProductOrder::create([
			    'product_id' => $faker->randomElement($products),
			    'user_id' => $faker->randomElement($users),
			    'quantity' => $faker->randomDigit,
			    'perform_at' => $faker->dateTime,
			    'comment' => $faker->text,
			    'status' => $status = $faker->randomElement(config('village.order.statuses')),
			    'decline_reason' => $status == 'rejected' ? $faker->text() : null,
		    ]);
	    }

	    for($i=0; $i < 10; $i++) {
		    Survey::create([
			    'title' => $faker->sentence(3),
			    'options' => json_encode(array('Yes', 'No', 'Maybe')),
			    'ends_at' => $faker->dateTimeBetween('-5 year'),
			    'active' => $faker->randomElement([0, 1]),
		    ]);
	    }
	    $surveys = $this->getItems(Modules\Village\Entities\Survey::class);

	    for($i=0; $i < 10; $i++) {
		    try {
			    SurveyVote::create([
				    'user_id' => $faker->randomElement($users),
				    'survey_id' => $faker->randomElement($surveys),
				    'choice' => $faker->randomElement(array(0, 1, 2))
			    ]);
		    }
		    catch (\Exception $e) {}
	    }

	    for($i=0; $i < 10; $i++) {
		    Option::create([
			    'key' => $faker->word,
			    'value' => $faker->sentence(3)
		    ]);
	    }

		Margin::create([
			'title' => $faker->sentence(3),
			'type' => $faker->randomElement((new Margin)->getTypes()),
			'value' => $faker->randomFloat(3, 0)
		]);
    }

	/**
	 * @param $model
	 *
	 * @return mixed
	 */
    protected function getItems($model)
    {
    	return (new $model)->lists('id')->toArray();
    }
}
