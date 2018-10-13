<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'lft' => $this->lft,  
            'rgt' => $this->rgt,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'salary' => $this->salary,
            'depth' => $this->depth,
            //'parent_id' => $this->parent_id,
            'parent' => $this->parent,
            'position' => $this->position,
            'employed_at' => $this->employed_at,
            'isLeaf' => $this->isLeaf(),
            'children_count' => $this->immediateDescendants()->count(),
          ];
    }
}
