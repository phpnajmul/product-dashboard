<?php

namespace App\Nova;

use App\Nova\Filters\ProductBrand;
use App\Nova\Metrics\AveragePrice;
use App\Nova\Metrics\NewProducts;
use App\Nova\Metrics\ProductPerDay;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public function subtitle()
    {
        return  "Brand: {$this->brand->name}";
    }

    public static $globalSearchResults = 10;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'description', 'sku'
    ];

    public static $clickAction = "edit";
    public static $perPageOptions = [50, 100, 150];

//    public static $tableStyle = "tight";
//
//    public static $showColumnBorders = true;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Slug::make('Slug')
                ->from('name')
                ->required()
                ->hideFromIndex()
                ->textAlign('left')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]]),

            Text::make('Name')
                ->required()
                ->showOnPreview()
                ->placeholder('Product name...')
                ->textAlign('left')
                ->sortable(),

            Markdown::make('Description')
                ->required()
                ->showOnPreview()
                ->textAlign('left'),

            Currency::make('Price')
                ->required()
                ->currency('EUR')
                ->showOnPreview()
                ->placeholder('Product price...')
                ->textAlign('left')
                ->sortable(),

            Text::make('Sku')
                ->required()
                ->placeholder('Product SKU...')
                ->textAlign('left')
                ->help('Number that retailers use to differentiate products and track inventory levels.')
                ->sortable(),

            Number::make('Quantity')
                ->required()
                ->showOnPreview()
                ->placeholder('Product quantity...')
                ->textAlign('left')
                ->sortable(),

            Boolean::make('Status', 'is_published')
                ->required()
                ->showOnPreview()
                ->textAlign('left')
                ->sortable(),
            BelongsTo::make('Brand')
                ->sortable()
                ->showOnPreview()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new NewProducts(),
            new AveragePrice(),
            new ProductPerDay()
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new ProductBrand()
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
