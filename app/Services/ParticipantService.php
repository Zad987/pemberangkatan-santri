<?php

namespace App\Services;

use App\Repositories\ParticipantRepository;
use App\Models\Participant;
use Illuminate\Support\Facades\Log;

class ParticipantService
{
    protected ParticipantRepository $participantRepository;

    public function __construct(ParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    /**
     * Create a new participant
     *
     * @param array $data
     * @return Participant
     */
    public function createParticipant(array $data): Participant
    {
        try {
            $data['created_by'] = auth()->id() ?? 0;
            
            $participant = $this->participantRepository->create($data);

            Log::info('Participant created', [
                'participant_id' => $participant->id ?? 0,
                'name' => $participant->name,
                'created_by' => auth()->id() ?? 0,
            ]);

            return $participant;
        } catch (\Exception $e) {
            Log::error('Error creating participant', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Update participant
     *
     * @param int $participantId
     * @param array $data
     * @return bool
     */
    public function updateParticipant(int $participantId, array $data): bool
    {
        try {
            $updated = $this->participantRepository->update($participantId, $data);

            if ($updated) {
                Log::info('Participant updated', [
                    'participant_id' => $participantId,
                    'updated_by' => auth()->id() ?? 0,
                ]);
            }

            return $updated;
        } catch (\Exception $e) {
            Log::error('Error updating participant', [
                'participant_id' => $participantId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Delete participant
     *
     * @param int $participantId
     * @return bool
     */
    public function deleteParticipant(int $participantId): bool
    {
        try {
            $deleted = $this->participantRepository->delete($participantId);

            if ($deleted) {
                Log::info('Participant deleted', [
                    'participant_id' => $participantId,
                    'deleted_by' => auth()->id() ?? 0,
                ]);
            }

            return $deleted;
        } catch (\Exception $e) {
            Log::error('Error deleting participant', [
                'participant_id' => $participantId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Get participant by ID with all relationships
     *
     * @param int $participantId
     * @return Participant
     */
    public function getParticipantById(int $participantId): Participant
    {
        return $this->participantRepository->findWithPayments($participantId);
    }

    /**
     * Get all participants
     *
     * @return mixed
     */
    public function getAllParticipants()
    {
        return $this->participantRepository->getAllWithRelations();
    }

    /**
     * Get participants by region
     *
     * @param int $regionId
     * @return mixed
     */
    public function getParticipantsByRegion(int $regionId)
    {
        return $this->participantRepository->getByRegion($regionId);
    }

    /**
     * Get participants by category
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getParticipantsByCategory(int $categoryId)
    {
        return $this->participantRepository->getByCategory($categoryId);
    }

    /**
     * Get paid participants
     *
     * @return mixed
     */
    public function getPaidParticipants()
    {
        return $this->participantRepository->getPaid();
    }

    /**
     * Get unpaid participants
     *
     * @return mixed
     */
    public function getUnpaidParticipants()
    {
        return $this->participantRepository->getUnpaid();
    }

    /**
     * Search participants
     *
     * @param string $term
     * @return mixed
     */
    public function searchParticipants(string $term)
    {
        return $this->participantRepository->search(['term' => $term]);
    }

    /**
     * Get paginated participants
     *
     * @param int $perPage
     * @return mixed
     */
    public function getPaginatedParticipants(int $perPage = 15)
    {
        return $this->participantRepository->paginateWithRelations($perPage);
    }

    /**
     * Get participant statistics
     *
     * @return array
     */
    public function getStatistics()
    {
        return $this->participantRepository->getStatistics();
    }

    /**
     * Check if participant is paid
     *
     * @param int $participantId
     * @return bool
     */
    public function isPaid(int $participantId): bool
    {
        $participant = $this->participantRepository->find($participantId);
        return $participant ? $participant->is_paid : false;
    }
}
