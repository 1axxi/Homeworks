<?php
//trait InitFields
//{
//    public $fields = ['field1', 'field2', 'field3', 'field4'];
//    public function handle(){
//        //дописать поля которые есть в нашей миграции
//       // вместо конструктора в каждджом классе юзать метод хендл принять набор полей,которые в мигрейт ап даун показать
//        //мигрейт ап и даун были статическими
//
//    }
//}

interface MigrationInterface
{
    public static function migrationDown();
    public static function migrationUp();

}
class PostgresMigrate implements MigrationInterface
{
    use InfoDb;
    public static function migrationDown()
    {
        $dbInfo = self::NameDb('Postgres','Sql','Mongo');
        $tables = self::WhichTable('email table','balance','users');
        $fields = self::CountOfFields(5,4,3);
         echo "Это {$dbInfo['Postgres']} бд, выполняю миграцию DOWN в {$tables['email table']} в количестве {$fields[5]} полей\n";
    }
    public static function migrationUp()
    {
        $dbInfo = self::NameDb('Postgres','Sql','Mongo');
        $tables = self::WhichTable('email table','balance','users');
        $fields = self::CountOfFields(5,4,3);
         echo "Это {$dbInfo['Postgres']} бд, выполняю миграцию UP в {$tables['email table']} в количестве {$fields[5]} полей\n";
    }
}


class MysqlMigrate implements MigrationInterface
{
    use InfoDb;
    public static function migrationDown()
    {
        $dbInfo = self::NameDb('Postgres','Sql','Mongo');
        $tables = self::WhichTable('email table','balance table','users table');
        $fields = self::CountOfFields(5,4,3);
        echo "Это {$dbInfo['Sql']} бд, выполняю миграцию DOWN в {$tables['balance table']} в количестве {$fields[4]} полей\n";
    }
    public static  function migrationUp()
    {
        $dbInfo = self::NameDb('Postgres','Sql','Mongo');
        $tables = self::WhichTable('email table','balance table','users table');
        $fields = self::CountOfFields(5,4,3);
        echo "Это {$dbInfo['Sql']} бд, выполняю миграцию UP в {$tables['balance table']} в количестве {$fields[4]} полей\n";
    }


}

class MongoDBMigrate implements MigrationInterface
{
    use InfoDb;
    public static function migrationDown()
    {
        $dbInfo = self::NameDb('Postgres','Sql','Mongo');
        $tables = self::WhichTable('email table','balance table','users table');
        $fields = self::CountOfFields(5,4,3);
         echo "Это {$dbInfo['Mongo']} бд, выполняю миграцию DOWN в {$tables['users table']} в количестве {$fields[3]} полей\n";
    }

    public static  function migrationUp()
    {
        $dbInfo = self::NameDb('Postgres','Sql','Mongo');
        $tables = self::WhichTable('email table','balance table','users table');
        $fields = self::CountOfFields(5,4,3);
        echo "Это {$dbInfo['Mongo']} бд, выполняю миграцию UP в {$tables['users table']} в количестве {$fields[3]} полей\n";
    }

}
    trait InfoDb
    {
        public static function nameDb($namePostgres,$nameSql,$nameMongo)
        {
            return [
                'Postgres' => $namePostgres,
                'Sql' => $nameSql,
                'Mongo' => $nameMongo
            ];
        }

        public static function whichTable($tablePostgres,$tableSql,$tableMongo)
        {
            return [
                'email table' => $tablePostgres,
                'balance table' => $tableSql,
                'users table' => $tableMongo
            ];
        }

        public static function countOfFields($fieldsPostgres,$fieldSql,$fieldMongo)
        {
            return [
                5 => $fieldsPostgres,
                4 => $fieldSql,
                3  => $fieldMongo
            ];
        }
    }

PostgresMigrate::migrationDown();
PostgresMigrate::migrationUp();

MysqlMigrate::migrationDown();
MysqlMigrate::migrationUp();

MongoDBMigrate::migrationDown();
MongoDBMigrate::migrationUp();
