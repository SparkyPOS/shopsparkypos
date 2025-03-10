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
            if (!empty($productCategories) && is_array($productCategories)) {
                $ids = [];
            
                foreach ($productCategories as $category) {
                    // Ensure ID exists or create a new one
                    $categoryId = $category['id'] ?? null;
            
                    $categoryModel = Category::updateOrCreate(
                        ['id' => $categoryId], // Match by ID
                        [
                            'name' => $category['name'],
                            'slug' => $category['product_key'] ? $category['product_key'] : Str::slug($category['name']),
                            'parent_id' => $category['parent_id'] ?? null,
                            'depth_level' => $category['parent_id'] ? 2 : 1,
                            'icon' => $category['preview_url'] ?? null,
                            'searchable' => 1,
                            'status' => 1,
                            'total_sale' => $category['total_items'] ?? 0,
                            'avg_rating' => 0,
                            'commission_rate' => 0
                        ]
                    );
            
                    $ids[] = $categoryModel->id; // Ensure the correct ID is stored
                }
            
                // Prevent accidental deletion of all categories
                if (!empty($ids)) {
                    Category::whereNotIn('id', $ids)->delete();
                }
            }            
            if (!empty($productAttributeSet) && is_array($productAttributeSet)) {
                $attributeSetIds = [];
            
                foreach ($productAttributeSet as $attributeSet) {
                    // Ensure ID exists or create a new one
                    $attributeSetId = $attributeSet['id'] ?? null;
            
                    $attribute = Attribute::updateOrCreate(
                        ['id' => $attributeSetId], // Match by ID
                        [
                            'name' => $attributeSet['title'],
                            'display_type' => $attributeSet['display_layout'],
                            'description' => '',
                            'status' => $attributeSet['status'] == 'published' ? 1 : 0,
                            'created_by' => 1,
                            'updated_by' => 1
                        ]
                    );
            
                    $attributeSetIds[] = $attribute->id; // Ensure correct ID is stored
                }
            
                // Prevent accidental mass deletion
                if (!empty($attributeSetIds)) {
                    Attribute::whereNotIn('id', $attributeSetIds)->delete();
                }
            }
            
            if (!empty($productAttribute) && is_array($productAttribute)) {
                $attributeValueIds = [];
            
                foreach ($productAttribute as $attribute) {
                    // Ensure ID exists or create a new one
                    $attributeId = $attribute['id'] ?? null;
            
                    $attributeValue = AttributeValue::updateOrCreate(
                        ['id' => $attributeId],
                        [
                            'value' => $attribute['title'],
                            'attribute_id' => $attribute['attribute_set_id']
                        ]
                    );
            
                    $attributeValueIds[] = $attributeValue->id; // Ensure correct ID is stored
                }
            
                // Prevent accidental mass deletion
                if (!empty($attributeValueIds)) {
                    AttributeValue::whereNotIn('id', $attributeValueIds)->delete();
                }
            }            
        } catch (\Throwable $th) {
            return [
                'success' => false, 
                'message' => $th->getMessage()
            ];
        }

        return [
            'success' => true
        ];
    }
}