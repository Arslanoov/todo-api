<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\OAuth;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Domain\Model\OAuth\Entity\AuthCode\AuthCode;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

final class DoctrineAuthCodeRepository implements AuthCodeRepositoryInterface
{
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        /** @var EntityRepository $repo */
        $repo = $em->getRepository(AuthCode::class);
        $this->repo = $repo;
        $this->em = $em;
    }

    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthCode();
    }

    /**
     * @param AuthCodeEntityInterface $accessTokenEntity
     * @throws UniqueTokenIdentifierConstraintViolationException
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $accessTokenEntity): void
    {
        if ($this->exists($accessTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->em->persist($accessTokenEntity);
        $this->em->flush();
    }

    /**
     * @param string $tokenId
     */
    public function revokeAuthCode($tokenId): void
    {
        if ($token = $this->repo->find($tokenId)) {
            $this->em->remove($token);
            $this->em->flush();
        }
    }

    /**
     * @param string $tokenId
     * @return bool
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function isAuthCodeRevoked($tokenId): bool
    {
        return !$this->exists($tokenId);
    }

    /**
     * @param string $id
     * @return bool
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    private function exists(string $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.identifier)')
                ->andWhere('t.identifier = :identifier')
                ->setParameter(':identifier', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
