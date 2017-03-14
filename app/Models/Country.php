<?php

namespace App\Models;

/**
 * App\Models\Country
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $continent
 * @property string $region
 * @property float $surface_area
 * @property integer $indep_year
 * @property integer $population
 * @property float $life_expectancy
 * @property float $gnp
 * @property float $gnp_old
 * @property string $local_name
 * @property string $government_form
 * @property string $head_of_state
 * @property integer $capital
 * @property string $code2
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereContinent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereSurfaceArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereIndepYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country wherePopulation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereLifeExpectancy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereGnp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereGnpOld($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereLocalName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereGovernmentForm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereHeadOfState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCapital($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCode2($value)
 */
class Country extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */


}
