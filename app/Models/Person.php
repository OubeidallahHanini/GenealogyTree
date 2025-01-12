<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model

{
    use HasFactory;
    protected $fillable = ['name', 'date_of_birth', 'created_by', 'is_approved'];

    public function relationships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Relationship::class, 'parent_id')
            ->orWhere('child_id', $this->id);
    }


    /**
     * Determine the degree of relationship with another person.
     *
     * @param int $target_person_id The ID of the person to find the degree of relationship with.
     * @return int|false The degree of relationship or false if it exceeds 25.
     */
    public function getDegreeWith($target_person_id)
    {
        $visited = [];  // to avoid cycles
        $queue = new \SplQueue();
        $queue->enqueue([$this->id, 0]); // [person_id, degree]

        while (!$queue->isEmpty()) {
            [$current_id, $degree] = $queue->dequeue();

            if ($degree > 25) {
                return false;
            }

            if ($current_id == $target_person_id) {
                return $degree;
            }

            // Get neighbors
            $relations = DB::select("
                SELECT parent_id AS related_person FROM relationships WHERE child_id = :person
                UNION
                SELECT child_id AS related_person FROM relationships WHERE parent_id = :person
            ", ['person' => $current_id]);

            foreach ($relations as $relation) {
                $related_person = $relation->related_person;
                if (!in_array($related_person, $visited)) {
                    $visited[] = $related_person;
                    $queue->enqueue([$related_person, $degree + 1]);
                }
            }
        }

        return false; // if no connection is found
    }

    /**
     * Get the user that created the person.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all children of the person.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * Get all parents of the person.
     */
    public function parents()
    {
        return $this->belongsToMany(self::class, 'relationships', 'child_id', 'parent_id');
    }
}
