<style>
    .refresh_btn{
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }
    .refresh_btn:hover{
        background-color: #fff;
        border-color: #fff;
    }
</style>
<div class="col-lg-4 col-xl-3">
    <div id="product_category_chose" class="product_category_chose mb_30 mt-1">
        <div class="course_title mb_15 d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="13" viewBox="0 0 19.5 13">
                <g id="filter-icon" transform="translate(28)">
                    <rect id="Rectangle_1" data-name="Rectangle 1" width="19.5" height="2" rx="1" transform="translate(-28)" fill="#fd4949"/>
                    <rect id="Rectangle_2" data-name="Rectangle 2" width="15.5" height="2" rx="1" transform="translate(-26 5.5)" fill="#fd4949"/>
                    <rect id="Rectangle_3" data-name="Rectangle 3" width="5" height="2" rx="1" transform="translate(-20.75 11)" fill="#fd4949"/>
                </g>
            </svg>
            <h5 class="font_16 f_w_700 mb-0 ">{{__('amazy.Filter Products')}}</h5>
            <div class="catgory_sidebar_closeIcon flex-fill justify-content-end d-flex d-lg-none">
                <button id="catgory_sidebar_closeIcon" class="home10_primary_btn2 gj-cursor-pointer mb-0 small_btn">{{__('amazy.close')}}</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-light text-dark refresh_btn" id="refresh_btn">{{__('amazy.refresh')}}</button>
        </div>
        <div class="course_category_inner">
          @php
          	$link_value=null;
            $link_type=null;
            $sigment = request()->segment(2);
          	if(isset($_GET['item']) && $_GET['item']=='brand' && $sigment != null)
            {

          		$link_type = 'brand';
          		$data_item =  DB::table('brands')->where('slug',$sigment)->first();
          		$link_value = !empty($data_item) ? $data_item->id:null;

            }

          $url = route('frontend.product_filter_by_type',[ 'filter' =>$link_type, 'filter_value' => $link_value]);
          @endphp

          @if($link_type != null && $link_value != null)
          <input type='hidden' id="filterUrl" value="{{$url}}">
          @else
          <input type='hidden' id="filterUrl" value="{{route('frontend.product_filter_by_type')}}" >
          @endif


            @isset($CategoryList)
                @if (count($CategoryList) > 0)
                    @foreach($CategoryList as $key => $category)
                    <div class="single_pro_categry">
                        <h4 class="font_18 f_w_700 getProductByChoice cursor_pointer" data-id="cat" data-value="{{ $category->id }}">
                            {{$category->name}}
                        </h4>
                        <ul class="Check_sidebar mb_35">
                            @if (count($category->subCategories) > 0)
                                @foreach($category->subCategories as $key => $subCategory)
                                <li>
                                    <label class="primary_checkbox d-flex">
                                        <input type="checkbox" class="getProductByChoice attr_checkbox" data-id="cat"
                                        data-value="{{ $subCategory->id }}">
                                        <span class="checkmark mr_10"></span>
                                        <span class="label_name">{{$subCategory->name}}</span>
                                    </label>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    @endforeach
                @endif
            @endisset
            @isset($color)
                @if ($color != null && $color->id == 1)
                    <div class="single_pro_categry">
                        <h4 class="font_18 f_w_700">
                            {{ $color->name }}
                        </h4>
                        <div class="color_filter">
                            @foreach ($color->values as $k => $color_name)
                                <div class="single_coulorFilter">
                                    <label class="round_checkbox d-flex" for="checkbox-{{$k}}">
                                        <input id="checkbox-{{$k}}" name="color[]" id="color" type="checkbox" color="color" data-id="{{ $color->id }}" data-value="{{ $color_name->id }}" class="getProductByChoice" value="{{ $color_name->color->name }}"/>
                                        <span class="checkmark colors_{{$k}}"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endisset
            <div class="single_pro_categry">
                <h4 class="font_18 f_w_700">
                {{__('common.filter_by_rating')}}
                </h4>
                <ul class="rating_lists mb_35">
                    <li>
                        <div class="ratings">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <label class="primary_checkbox d-flex filter-by-rating-one">
                                <input type="checkbox" name="attr_value[]" class="getProductByChoice attr_checkbox" data-id="rating" data-value="5" id="attr_value">
                                <span class="checkmark mr_10"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="ratings">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star unrated"></i>
                            <span>{{__('defaultTheme.and_up')}}</span>
                            <label class="primary_checkbox d-flex filter-by-ratings">
                                <input type="checkbox" name="attr_value[]" class="getProductByChoice attr_checkbox" data-id="rating" data-value="4" id="attr_value">
                                <span class="checkmark mr_10"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="ratings">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star unrated"></i>
                            <i class="fas fa-star unrated"></i>
                            <span>{{__('defaultTheme.and_up')}}</span>
                            <label class="primary_checkbox d-flex filter-by-ratings">
                                <input type="checkbox" name="attr_value[]" class="getProductByChoice attr_checkbox" data-id="rating" data-value="3" id="attr_value">
                                <span class="checkmark mr_10"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="ratings">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star unrated"></i>
                            <i class="fas fa-star unrated"></i>
                            <i class="fas fa-star unrated"></i>
                            <span>{{__('defaultTheme.and_up')}}</span>
                            <label class="primary_checkbox d-flex filter-by-ratings">
                                <input type="checkbox" name="attr_value[]" class="getProductByChoice attr_checkbox" data-id="rating" data-value="2" id="attr_value">
                                <span class="checkmark mr_10"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="ratings">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star unrated"></i>
                            <i class="fas fa-star unrated"></i>
                            <i class="fas fa-star unrated"></i>
                            <i class="fas fa-star unrated"></i>
                            <span>{{__('defaultTheme.and_up')}}</span>
                            <label class="primary_checkbox d-flex filter-by-ratings">
                                <input type="checkbox" name="attr_value[]" class="getProductByChoice attr_checkbox" data-id="rating" data-value="1" id="attr_value">
                                <span class="checkmark mr_10"></span>
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="single_pro_categry">
                <h4 class="font_18 f_w_700">
                {{__('common.filter_by_price')}}
                </h4>
                <div class="filter_wrapper">
                    <input type="hidden" id="min_price" value="{{ $min_price_lowest }}" />
                    <input type="hidden" id="max_price" value="{{ $max_price_highest }}" />
                    <div id="slider-range"></div>
                    <div class="d-flex align-items-center prise_line">
                        <button class="home10_primary_btn2 mr_20 mb-0 small_btn js-range-slider-0">{{__('common.filter')}}</button>
                        <span>{{__('common.price')}}: </span> <input type="text" id="amount" readonly >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
