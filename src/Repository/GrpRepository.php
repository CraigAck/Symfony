<?php

namespace App\Repository;

use App\Entity\Grp;
use App\Entity\GrpsUsers;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Grp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grp[]    findAll()
 * @method Grp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Grp::class);
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllWithMembers(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT g.id, g.name, u.id as userId, u.name AS userName 
            FROM grp g
            LEFT JOIN grps_users gu ON gu.grp_id_id = g.id
            LEFT JOIN user u ON u.id = gu.user_id_id
            ORDER BY g.id ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    /**
     * @param string $name
     * @return Grp
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(string $name): array
    {
        $group = new Grp;
        $group->setName($name);

        $this->save($group);

        return $this->findAllWithMembers();
    }

    /**
     * @param $id
     * @param GrpsUsersRepository $grpsUsersRepository
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteGroup($id): bool
    {
        if (!$this->_em->getRepository(GrpsUsers::class)
            ->findOneBy(['grpId' => $id]))
        {
            $group = $this->find($id);
            $this->remove($group);

            return true;
        }

        return false;
    }

    /**
     * @param int $id
     * @param int $userId
     * @return array|bool
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addUser(int $id, int $userId)
    {
        if (is_null($this->_em->getRepository(GrpsUsers::class)
            ->findOneBy(['grpId' => $id, 'userId' => $userId])))
        {
            $group = $this->find($id);
            $user = $this->_em->getRepository(User::class)
                ->find($userId);

            $grpUser = (new GrpsUsers())
                ->setGrpId($group)
                ->setUserId($user);

            $this->_em->persist($grpUser);
            $this->_em->flush();

            return $this->findAllWithMembers();
        }

        return null;
    }

    /**
     * @param $id
     * @param $userId
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteUser($id, $userId): bool
    {
        if ($grpUser = $this->_em->getRepository(GrpsUsers::class)
            ->findOneBy(['grpId' => $id, 'userId' => $userId]))
        {
            $this->_em->remove($grpUser);
            $this->_em->flush();

            return true;
        }

        return false;
    }

    /**
     * @param Grp $group
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Grp $group)
    {
        $this->_em->persist($group);
        $this->_em->flush();
    }

    /**
     * @param Grp $group
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Grp $group)
    {
        $this->_em->remove($group);
        $this->_em->flush();
    }
}
