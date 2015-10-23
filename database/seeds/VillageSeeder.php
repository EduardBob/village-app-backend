<?php

use Cartalyst\Sentinel\Activations\EloquentActivation;
use Illuminate\Database\Seeder;

use Modules\Village\Entities\User;

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

use Modules\Village\Entities\Margin;
use Modules\Village\Entities\Village;

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

	    $users = $this->getItems(User::class);
	    User::destroy($users);
	    $activations = $this->getItems(EloquentActivation::class);
	    EloquentActivation::destroy($activations);

	    for($i=0; $i < 5; $i++) {
		    Village::create([
			    'name' => $faker->domainName,
			    'shop_name' => $faker->userName,
			    'shop_address' =>  $faker->streetAddress,
			    'service_payment_info' => $faker->text,
			    'service_bottom_text' => $faker->text,
			    'product_payment_info' => $faker->text,
			    'product_bottom_text' => $faker->text,
			    'product_unit_step_kg' => $faker->randomElement([0.5, 1]),
			    'product_unit_step_bottle' => $faker->randomElement([1, 2]),
			    'product_unit_step_piece' => $faker->randomElement([1, 2]),
			    'active' => $faker->randomElement([0, 1]),
			    'created_at' => $createdAt = $faker->dateTime,
			    'updated_at' => $createdAt,
		    ]);
	    }
	    $villages = $this->getItems(Village::class);

	    foreach($villages as $villageId) {
		    for($i=0; $i < 100; $i++) {
			    try {
				    Building::create([
					    'village_id' => $villageId,
					    'address' => $faker->unique()->address,
					    'code' => $i > 0 ? str_random(10) : 'test',
				    ]);
			    }
			    catch(\Exception $e){}
		    }
		    $buildings = $this->getItems(Building::class);

		    for($i=0; $i < 100; $i++) {
			    try {
				    $user = (new User)->fill([
					    'password' => Hash::make($i > 0 ? $faker->password : 'yj3wev32R6eQJWV'),
					    'permissions' => $i > 0 ? [] : json_decode('{"dashboard.grid.save":true,"dashboard.grid.reset":true,"dashboard.index":true,"media.media.index":true,"media.media.create":true,"media.media.store":true,"media.media.edit":true,"media.media.update":true,"media.media.destroy":true,"media.media-grid.index":true,"media.media-grid.ckIndex":true,"menu.menus.index":false,"menu.menus.create":false,"menu.menus.store":false,"menu.menus.edit":false,"menu.menus.update":false,"menu.menus.destroy":false,"menu.menuitem.index":false,"menu.menuitem.create":false,"menu.menuitem.store":false,"menu.menuitem.edit":false,"menu.menuitem.update":false,"menu.menuitem.destroy":false,"page.pages.index":false,"page.pages.create":false,"page.pages.store":false,"page.pages.edit":false,"page.pages.update":false,"page.pages.destroy":false,"setting.settings.index":true,"setting.settings.getModuleSettings":true,"setting.settings.store":true,"user.users.index":true,"user.users.create":true,"user.users.store":true,"user.users.edit":true,"user.users.update":true,"user.users.destroy":true,"user.roles.index":true,"user.roles.create":true,"user.roles.store":true,"user.roles.edit":true,"user.roles.update":true,"user.roles.destroy":true,"village.villages.index":true,"village.villages.create":true,"village.villages.store":true,"village.villages.edit":true,"village.villages.update":true,"village.villages.destroy":true,"village.buildings.index":true,"village.buildings.create":true,"village.buildings.store":true,"village.buildings.edit":true,"village.buildings.update":true,"village.buildings.destroy":true,"village.articles.index":true,"village.articles.create":true,"village.articles.store":true,"village.articles.edit":true,"village.articles.update":true,"village.articles.destroy":true,"village.margins.index":true,"village.margins.create":true,"village.margins.store":true,"village.margins.edit":true,"village.margins.update":true,"village.margins.destroy":true,"village.options.index":true,"village.options.create":true,"village.options.store":true,"village.options.edit":true,"village.options.update":true,"village.options.destroy":true,"village.products.index":true,"village.products.create":true,"village.products.store":true,"village.products.edit":true,"village.products.update":true,"village.products.destroy":true,"village.productcategories.index":true,"village.productcategories.create":true,"village.productcategories.store":true,"village.productcategories.edit":true,"village.productcategories.update":true,"village.productcategories.destroy":true,"village.productorders.index":true,"village.productorders.create":true,"village.productorders.store":true,"village.productorders.edit":true,"village.productorders.update":true,"village.productorders.destroy":true,"village.services.index":true,"village.services.create":true,"village.services.store":true,"village.services.edit":true,"village.services.update":true,"village.services.destroy":true,"village.servicecategories.index":true,"village.servicecategories.create":true,"village.servicecategories.store":true,"village.servicecategories.edit":true,"village.servicecategories.update":true,"village.servicecategories.destroy":true,"village.serviceorders.index":true,"village.serviceorders.create":true,"village.serviceorders.store":true,"village.serviceorders.edit":true,"village.serviceorders.update":true,"village.serviceorders.destroy":true,"village.surveys.index":true,"village.surveys.create":true,"village.surveys.store":true,"village.surveys.edit":true,"village.surveys.update":true,"village.surveys.destroy":true,"village.surveyvotes.index":true,"village.surveyvotes.create":true,"village.surveyvotes.store":true,"village.surveyvotes.edit":true,"village.surveyvotes.update":true,"village.surveyvotes.destroy":true,"village.tokens.index":true,"village.tokens.create":true,"village.tokens.store":true,"village.tokens.edit":true,"village.tokens.update":true,"village.tokens.destroy":true,"workshop.modules.index":false,"workshop.modules.show":false,"workshop.modules.disable":false,"workshop.modules.enable":false,"workshop.themes.index":false,"workshop.themes.show":false}', true),
					    'first_name' => $i > 0 ? $faker->firstName : 'admin',
					    'last_name' => $i > 0 ? $faker->lastName : 'admin',
					    'phone' => $i > 0 ? $faker->unique()->phoneNumber : '+7(111)1111111',
					    'building_id' => $faker->randomElement($buildings),
				    ]);
				    $user->save();

				    $activation = Activation::exists($user);
				    if (!$activation) {
					    $activation = Activation::create($user);
					    if ($i == 0 || $faker->boolean()) {
						    Activation::complete($user, $activation->getCode());
					    }
				    }
			    }
			    catch (\Exception $e) {}
		    }
		    $users = $this->getItems(User::class);


		    $createdAt = (new \DateTime())->modify('-1 years');
		    for($i=0; $i < 100; $i++) {
			    Article::create([
				    'village_id' => $villageId,
				    'title' => $faker->sentence(3),
				    'text' => $faker->text(1000),
				    'created_at' => $createdAt->modify('+3 days'),
				    'updated_at' => $faker->dateTimeBetween($createdAt),
				    'active' => $faker->randomElement([0, 1]),
			    ]);
		    }


		    for($i=0; $i < 20; $i++) {
			    ServiceCategory::create([
				    'village_id' => $villageId,
				    'title' => $faker->unique()->sentence(3),
				    'active' => $faker->randomElement([0, 1]),
				    'order' => $faker->randomElement([0, 100]),
			    ]);
		    }
		    $serviceCategories = $this->getItems(Modules\Village\Entities\ServiceCategory::class);

		    for($i=0; $i < 50; $i++) {
			    Service::create([
				    'village_id' => $villageId,
				    'category_id' => $faker->randomElement($serviceCategories),
				    'title' => $faker->unique()->sentence(3),
				    'price' => $faker->randomFloat(4, 0, 1000),
				    'active' => $faker->randomElement([0, 1]),
				    'text'   => $faker->text(),
				    'comment_label' => 'Ваши пожелания и заметки',
				    'order_button_label' => 'Заказать',
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
				    'village_id' => $villageId,
				    'title' => str_random(10),
				    'active' => $faker->randomElement([0, 1]),
				    'order' => $faker->randomElement([0, 100]),
			    ]);
		    }
		    $productCategories = $this->getItems(Modules\Village\Entities\ProductCategory::class);

		    for($i=0; $i < 50; $i++) {
			    Product::create([
				    'village_id' => $villageId,
				    'category_id' => $faker->randomElement($productCategories),
				    'title' => $faker->unique()->sentence(3),
				    'price' => $faker->randomFloat(4, 0),
				    'unit_title' => $faker->randomElement(config('village.product.unit.values')),
				    'image' => $faker->imageUrl(640, 480),
				    'active' => $faker->randomElement([0, 1]),
				    'text'   => $faker->text(),
				    'comment_label' => 'Ваши пожелания и заметки',
			    ]);
		    }
		    $products = $this->getItems(Modules\Village\Entities\Product::class);

		    for($i=0; $i < 50; $i++) {
			    ProductOrder::create([
				    'product_id' => $faker->randomElement($products),
				    'user_id' => $faker->randomElement($users),
				    'quantity' => $faker->randomDigitNotNull,
				    'perform_at' => $faker->dateTime,
				    'comment' => $faker->text,
				    'status' => $status = $faker->randomElement(config('village.order.statuses')),
				    'decline_reason' => $status == 'rejected' ? $faker->text() : null,
			    ]);
		    }

		    for($i=0; $i < 100; $i++) {
			    Survey::create([
				    'village_id' => $villageId,
				    'title' => $faker->sentence(3),
				    'options' => json_encode(array('Yes', 'No', 'Maybe')),
				    'ends_at' => $faker->dateTimeBetween('-1 year', '+1 year'),
				    'active' => $faker->randomElement([0, 1]),
			    ]);
		    }
		    $surveys = $this->getItems(Modules\Village\Entities\Survey::class);

		    for($i=0; $i < 500; $i++) {
			    try {
				    SurveyVote::create([
					    'user_id' => $faker->randomElement($users),
					    'survey_id' => $faker->randomElement($surveys),
					    'choice' => $faker->randomElement(array(0, 1, 2))
				    ]);
			    }
			    catch (\Exception $e) {}
		    }

		    Margin::create([
			    'village_id' => $villageId,
			    'title' => $faker->sentence(3),
			    'type' => $faker->randomElement((new Margin)->getTypes()),
			    'value' => $faker->randomFloat(3, 0)
		    ]);
	    }
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
