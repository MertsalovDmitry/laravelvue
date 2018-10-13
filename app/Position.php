<?php

namespace App;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoinTrait;
//use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //use Searchable; 
    use EloquentJoinTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->useTableAlias = true;
    }

    protected $fillable = ['name'];

    public function employees() {
        return $this->hasMany(Employee::class);
      }
}
