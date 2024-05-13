<?php

namespace Tests\App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductFileControllerTest extends TestCase
{
    /**
     * Upload product .csv file.
     * artisan test --filter=ProductFileControllerTest
     * @return void
     */
    public function testStore(): void
    {

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('products.csv', 100);

        $this->actingAs($user);
        $response = $this->postJson(route('product.file'), ['file' => $file]);
        $response->assertStatus(200);

        $response->assertJson(['message' => 'Products imported successfully']);
        $this->assertDatabaseHas(
            'products',
            [
                'barcode' => '1',
                'name' => 'AZEITE  PORTUGUÊS EXTRA VIRGEM GALLO 500ML',
            ]
        );
    }
}
