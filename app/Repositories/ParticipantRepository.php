<?php

namespace App\Repositories;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;

class ParticipantRepository extends BaseRepository
{
    /**
     * Get the model class
     *
     * @return Model
     */
    protected function getModel(): Model
    {
        return new Participant();
    }

    /**
     * Get all participants with relationships
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithRelations()
    {
        return $this->model->with(['region', 'category', 'payments'])->get();
    }

    /**
     * Get participants by region
     *
     * @param int $regionId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByRegion(int $regionId)
    {
        return $this->model->with(['region', 'category', 'payments'])
            ->where('region_id', $regionId)
            ->get();
    }

    /**
     * Get participants by category
     *
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCategory(int $categoryId)
    {
        return $this->model->with(['region', 'category', 'payments'])
            ->where('category_id', $categoryId)
            ->get();
    }

    /**
     * Get paid participants
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaid()
    {
        return $this->model->with(['region', 'category', 'payments'])
            ->whereHas('payments', function ($q) {
                $q->where('status', 'lunas');
            })
            ->get();
    }

    /**
     * Get unpaid participants
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnpaid()
    {
        return $this->model->with(['region', 'category', 'payments'])
            ->whereDoesntHave('payments', function ($q) {
                $q->where('status', 'lunas');
            })
            ->get();
    }

    /**
     * Search participants by name or email
     *
     * @param array|string $term
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($term, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        // If $term is array (from parent), use parent implementation
        if (is_array($term)) {
            if (isset($term['term'])) {
                // Handle the specific case where we pass ['term' => 'search_value']
                $searchTerm = $term['term'];
                return $this->model->with(['region', 'category', 'payments'])
                    ->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                    ->get();
            } else {
                // Use parent search for other array formats
                return parent::search($term, $columns);
            }
        }
        
        // Otherwise, search by name, email, or phone
        return $this->model->with(['region', 'category', 'payments'])
            ->where('name', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('phone', 'LIKE', "%{$term}%")
            ->get();
    }

    /**
     * Get participants with payment details
     *
     * @param int $id
     * @return Participant|null
     */
    public function findWithPayments(int $id)
    {
        return $this->model->with(['region', 'category', 'payments', 'creator'])->findOrFail($id);
    }

    /**
     * Get paginated participants
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginateWithRelations(int $perPage = 15)
    {
        return $this->model->with(['region', 'category', 'payments'])
            ->paginate($perPage);
    }

    /**
     * Get statistics
     *
     * @return array
     */
    public function getStatistics()
    {
        $total = $this->count();
        $paid = $this->model->whereHas('payments', function ($q) {
            $q->where('status', 'lunas');
        })->count();
        $unpaid = $total - $paid;

        return [
            'total' => $total,
            'paid' => $paid,
            'unpaid' => $unpaid,
            'paid_percentage' => $total > 0 ? round(($paid / $total) * 100, 2) : 0,
        ];
    }
}
