<?php

declare(strict_types=1);

namespace Infrastructure;


class BookingAuditRepository extends EntityRepository implements BookingAuditRepositoryInterface
{
    public function __construct(EntityManagerInterface $em, ?ClassMetadata $class = null)
    {
        if (empty($class)) {
            $class = $em->getClassMetadata(BookingAuditEntity::class);
        }
        parent::__construct($em, $class);
    }

    public function getById(int $id): ?BookingAuditEntity
    {
        return $this->find($id);
    }

    public function createBookingAudit(BookingEntity $booking, int $userId): BookingAuditEntity
    {
        $bookingAudit = new BookingAuditEntity();
        $bookingAudit->setDate(new DateTime())
            ->setBooking($booking)
            ->setValue( BookingAuditDispatcher::createBookingAuditJson($booking))
            ->setUpdatedBy($userId);

        $this->getEntityManager()->persist($bookingAudit);
        $this->getEntityManager()->flush();

        return $bookingAudit;
    }
}
