<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20200521120258 extends AbstractMigration
{
    private const TABLE = 'persons';

    public function getDescription(): string
    {
        return 'Creating Table Persons with Default Values';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE);

        $table->addColumn(
            'id',
            Types::INTEGER,
            [
                'autoincrement' => true,
            ]
        );

        $table->addColumn(
            'firstname',
            Types::STRING,
            [
                'length' => 25,
            ]
        );

        $table->addColumn(
            'lastname',
            Types::STRING,
            [
                'length' => 25,
            ]
        );

        $table->addColumn(
            'age',
            Types::INTEGER,
            [
                'length' => 11,
                'notnull' => false,
            ]
        );

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE);
    }
}
