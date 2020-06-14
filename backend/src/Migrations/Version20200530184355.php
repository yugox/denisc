<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530184355 extends AbstractMigration
{
    private const TABLE = 'User';
    private const COLUMN = 'LogoutAt';

    public function getDescription() : string
    {
        return 'Add LogoutAt to User';
    }

    public function up(Schema $schema) : void
    {
        $schema->getTable(self::TABLE)
            ->addColumn(self::COLUMN, Types::DATETIME_MUTABLE)
            ->setNotnull(false);
    }

    public function down(Schema $schema) : void
    {
        $schema->getTable(self::TABLE)->dropColumn(self::COLUMN);
    }
}
