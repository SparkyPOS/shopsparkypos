<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Entities\Category;
use Illuminate\Support\Str;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;

class SyncSparkyController extends Controller
{
    public function __construct()
    {

    }
    public function sync(Request $request)
    {
        try {
            $productCategories = $request->post('product_category');
            $productAttributeSet = $request->post('product_attribute_set');
            $productAttribute = $request->post('product_attribute');
            if ($productCategories && is_array($productCategories)) {
                foreach ($productCategories as $category) {
                    Category::updateOrCreate(
                        ['id' => $category['id']], // Match by ID
                        [
                            'name' => $category['name'],
                            'slug' => $category['product_key'] ? $category['product_key'] : Str::slug($category['name']), // Generate slug from name
                            'parent_id' => $category['parent_id'] ?? null,
                            'depth_level' => $category['parent_id'] ? 2 : 1, // Assume depth logic
                            'icon' => $category['preview_url'] ?? null, // Assuming media URL
                            'searchable' => 1, // Default to searchable
                            'status' => 1, // Active by default
                            'total_sale' => $category['total_items'] ?? 0,
                            'avg_rating' => 0, // Set default rating
                            'commission_rate' => 0
                        ]
                    );
                }
            }

            if ($productAttributeSet && is_array($productAttributeSet)) {
                foreach ($productAttributeSet as $attributeSet) {
                    Attribute::updateOrCreate(
                        ['id' => $attributeSet['id']],
                        [
                            'name' => $attributeSet['title'],
                            'display_type' => $attributeSet['display_layout'],
                            'description' => '',
                            'status' => $attributeSet['status'] == 'published' ? 1 : 0,
                            'created_by' => 1,
                            'updated_by' => 1
                        ]
                    );
                }
            }

            if ($productAttribute && is_array($productAttribute)) {
                foreach ($productAttribute as $attribute) {
                    AttributeValue::updateOrCreate(
                        ['id' => $attribute['id']],
                        [
                            'value' => $attribute['title'],
                            'attribute_id' => $attribute['attribute_set_id']
                        ]
                    );
                }
            }
        } catch (\Throwable $th) {
            return [
                'success' => false, 
                'message' => $th->getMessage()
            ];
        }

        return [
            'success' => true, 
            'data' => $request->all()
        ];
    }
}