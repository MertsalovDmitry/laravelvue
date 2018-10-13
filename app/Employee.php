<?php
namespace App;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoinTrait;
use Baum\Node;
//use Laravel\Scout\Searchable;
use App\Position;


/**
* Employee
*/
class Employee extends Node {

  //use Searchable; 
  use EloquentJoinTrait;

  public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->useTableAlias = true;
    }

  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'employees';

  protected $fillable = ['firstname', 'middlename', 'lastname', 'salary', 'position_id','employed_at', 'parent_id'];

  public function position() {
    return $this->belongsTo(Position::class);
  }

  public function parent(){
    //return $this->belongsTo(Employee::class, 'parent_id');
    return $this->belongsTo(self::class, 'parent_id');
  }

  public function toSearchableArray()
  {
    $array = [
      'firstname' => $this->firstname,
      'middlename' => $this->middlename,
      'lastname' => $this->lastname,
      'salary' => $this->salary,
    ];

    return $array;
  }

  //protected $dates = ['created_at', 'employed_at'];
  //////////////////////////////////////////////////////////////////////////////

  //
  // Below come the default values for Baum's own Nested Set implementation
  // column names.
  //
  // You may uncomment and modify the following fields at your own will, provided
  // they match *exactly* those provided in the migration.
  //
  // If you don't plan on modifying any of these you can safely remove them.
  //

  // /**
  //  * Column name which stores reference to parent's node.
  //  *
  //  * @var string
  //  */
  // protected $parentColumn = 'parent_id';

  // /**
  //  * Column name for the left index.
  //  *
  //  * @var string
  //  */
  // protected $leftColumn = 'lft';

  // /**
  //  * Column name for the right index.
  //  *
  //  * @var string
  //  */
  // protected $rightColumn = 'rgt';

  // /**
  //  * Column name for the depth field.
  //  *
  //  * @var string
  //  */
  // protected $depthColumn = 'depth';

  // /**
  //  * Column to perform the default sorting
  //  *
  //  * @var string
  //  */
  // protected $orderColumn = null;

  // /**
  // * With Baum, all NestedSet-related fields are guarded from mass-assignment
  // * by default.
  // *
  // * @var array
  // */
  // protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

  //
  // This is to support "scoping" which may allow to have multiple nested
  // set trees in the same database table.
  //
  // You should provide here the column names which should restrict Nested
  // Set queries. f.ex: company_id, etc.
  //

  // /**
  //  * Columns which restrict what we consider our Nested Set list
  //  *
  //  * @var array
  //  */
  // protected $scoped = array();

  //////////////////////////////////////////////////////////////////////////////

  //
  // Baum makes available two model events to application developers:
  //
  // 1. `moving`: fired *before* the a node movement operation is performed.
  //
  // 2. `moved`: fired *after* a node movement operation has been performed.
  //
  // In the same way as Eloquent's model events, returning false from the
  // `moving` event handler will halt the operation.
  //
  // Please refer the Laravel documentation for further instructions on how
  // to hook your own callbacks/observers into this events:
  // http://laravel.com/docs/5.0/eloquent#model-events

}
