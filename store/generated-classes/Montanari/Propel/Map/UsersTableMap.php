<?php

namespace Montanari\Propel\Map;

use Montanari\Propel\Users;
use Montanari\Propel\UsersQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'users' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UsersTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Montanari.Propel.Map.UsersTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'users';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Montanari\\Propel\\Users';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Montanari.Propel.Users';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'users.id';

    /**
     * the column name for the username field
     */
    const COL_USERNAME = 'users.username';

    /**
     * the column name for the nome field
     */
    const COL_NOME = 'users.nome';

    /**
     * the column name for the cognome field
     */
    const COL_COGNOME = 'users.cognome';

    /**
     * the column name for the password field
     */
    const COL_PASSWORD = 'users.password';

    /**
     * the column name for the abitazione field
     */
    const COL_ABITAZIONE = 'users.abitazione';

    /**
     * the column name for the autonomia field
     */
    const COL_AUTONOMIA = 'users.autonomia';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'users.email';

    /**
     * the column name for the id_player_notifiche field
     */
    const COL_ID_PLAYER_NOTIFICHE = 'users.id_player_notifiche';

    /**
     * the column name for the insert_date field
     */
    const COL_INSERT_DATE = 'users.insert_date';

    /**
     * the column name for the email_confirm field
     */
    const COL_EMAIL_CONFIRM = 'users.email_confirm';

    /**
     * the column name for the first_access field
     */
    const COL_FIRST_ACCESS = 'users.first_access';

    /**
     * the column name for the code_confirm field
     */
    const COL_CODE_CONFIRM = 'users.code_confirm';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Username', 'Nome', 'Cognome', 'Password', 'Abitazione', 'Autonomia', 'Email', 'IdPlayerNotifiche', 'InsertDate', 'EmailConfirm', 'FirstAccess', 'CodeConfirm', ),
        self::TYPE_CAMELNAME     => array('id', 'username', 'nome', 'cognome', 'password', 'abitazione', 'autonomia', 'email', 'idPlayerNotifiche', 'insertDate', 'emailConfirm', 'firstAccess', 'codeConfirm', ),
        self::TYPE_COLNAME       => array(UsersTableMap::COL_ID, UsersTableMap::COL_USERNAME, UsersTableMap::COL_NOME, UsersTableMap::COL_COGNOME, UsersTableMap::COL_PASSWORD, UsersTableMap::COL_ABITAZIONE, UsersTableMap::COL_AUTONOMIA, UsersTableMap::COL_EMAIL, UsersTableMap::COL_ID_PLAYER_NOTIFICHE, UsersTableMap::COL_INSERT_DATE, UsersTableMap::COL_EMAIL_CONFIRM, UsersTableMap::COL_FIRST_ACCESS, UsersTableMap::COL_CODE_CONFIRM, ),
        self::TYPE_FIELDNAME     => array('id', 'username', 'nome', 'cognome', 'password', 'abitazione', 'autonomia', 'email', 'id_player_notifiche', 'insert_date', 'email_confirm', 'first_access', 'code_confirm', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Username' => 1, 'Nome' => 2, 'Cognome' => 3, 'Password' => 4, 'Abitazione' => 5, 'Autonomia' => 6, 'Email' => 7, 'IdPlayerNotifiche' => 8, 'InsertDate' => 9, 'EmailConfirm' => 10, 'FirstAccess' => 11, 'CodeConfirm' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'username' => 1, 'nome' => 2, 'cognome' => 3, 'password' => 4, 'abitazione' => 5, 'autonomia' => 6, 'email' => 7, 'idPlayerNotifiche' => 8, 'insertDate' => 9, 'emailConfirm' => 10, 'firstAccess' => 11, 'codeConfirm' => 12, ),
        self::TYPE_COLNAME       => array(UsersTableMap::COL_ID => 0, UsersTableMap::COL_USERNAME => 1, UsersTableMap::COL_NOME => 2, UsersTableMap::COL_COGNOME => 3, UsersTableMap::COL_PASSWORD => 4, UsersTableMap::COL_ABITAZIONE => 5, UsersTableMap::COL_AUTONOMIA => 6, UsersTableMap::COL_EMAIL => 7, UsersTableMap::COL_ID_PLAYER_NOTIFICHE => 8, UsersTableMap::COL_INSERT_DATE => 9, UsersTableMap::COL_EMAIL_CONFIRM => 10, UsersTableMap::COL_FIRST_ACCESS => 11, UsersTableMap::COL_CODE_CONFIRM => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'username' => 1, 'nome' => 2, 'cognome' => 3, 'password' => 4, 'abitazione' => 5, 'autonomia' => 6, 'email' => 7, 'id_player_notifiche' => 8, 'insert_date' => 9, 'email_confirm' => 10, 'first_access' => 11, 'code_confirm' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('users');
        $this->setPhpName('Users');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Montanari\\Propel\\Users');
        $this->setPackage('Montanari.Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 30, null);
        $this->addColumn('nome', 'Nome', 'VARCHAR', true, 30, null);
        $this->addColumn('cognome', 'Cognome', 'VARCHAR', true, 30, null);
        $this->addColumn('password', 'Password', 'VARCHAR', true, 32, null);
        $this->addColumn('abitazione', 'Abitazione', 'VARCHAR', false, 40, null);
        $this->addColumn('autonomia', 'Autonomia', 'BOOLEAN', true, 1, false);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 50, null);
        $this->addColumn('id_player_notifiche', 'IdPlayerNotifiche', 'VARCHAR', false, 40, null);
        $this->addColumn('insert_date', 'InsertDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('email_confirm', 'EmailConfirm', 'BOOLEAN', true, 1, false);
        $this->addColumn('first_access', 'FirstAccess', 'BOOLEAN', true, 1, true);
        $this->addColumn('code_confirm', 'CodeConfirm', 'VARCHAR', false, 16, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Drivers', '\\Montanari\\Propel\\Drivers', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_user',
    1 => ':id',
  ),
), null, null, 'Driverss', false);
        $this->addRelation('MessagesRelatedByIdUserFrom', '\\Montanari\\Propel\\Messages', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_user_from',
    1 => ':id',
  ),
), null, null, 'MessagessRelatedByIdUserFrom', false);
        $this->addRelation('MessagesRelatedByIdUserTo', '\\Montanari\\Propel\\Messages', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_user_to',
    1 => ':id',
  ),
), null, null, 'MessagessRelatedByIdUserTo', false);
        $this->addRelation('Passengers', '\\Montanari\\Propel\\Passengers', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_user',
    1 => ':id',
  ),
), null, null, 'Passengerss', false);
        $this->addRelation('UserSettings', '\\Montanari\\Propel\\UserSettings', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':id_user',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? UsersTableMap::CLASS_DEFAULT : UsersTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Users object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UsersTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UsersTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UsersTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UsersTableMap::OM_CLASS;
            /** @var Users $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UsersTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = UsersTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UsersTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Users $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UsersTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(UsersTableMap::COL_ID);
            $criteria->addSelectColumn(UsersTableMap::COL_USERNAME);
            $criteria->addSelectColumn(UsersTableMap::COL_NOME);
            $criteria->addSelectColumn(UsersTableMap::COL_COGNOME);
            $criteria->addSelectColumn(UsersTableMap::COL_PASSWORD);
            $criteria->addSelectColumn(UsersTableMap::COL_ABITAZIONE);
            $criteria->addSelectColumn(UsersTableMap::COL_AUTONOMIA);
            $criteria->addSelectColumn(UsersTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UsersTableMap::COL_ID_PLAYER_NOTIFICHE);
            $criteria->addSelectColumn(UsersTableMap::COL_INSERT_DATE);
            $criteria->addSelectColumn(UsersTableMap::COL_EMAIL_CONFIRM);
            $criteria->addSelectColumn(UsersTableMap::COL_FIRST_ACCESS);
            $criteria->addSelectColumn(UsersTableMap::COL_CODE_CONFIRM);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.username');
            $criteria->addSelectColumn($alias . '.nome');
            $criteria->addSelectColumn($alias . '.cognome');
            $criteria->addSelectColumn($alias . '.password');
            $criteria->addSelectColumn($alias . '.abitazione');
            $criteria->addSelectColumn($alias . '.autonomia');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.id_player_notifiche');
            $criteria->addSelectColumn($alias . '.insert_date');
            $criteria->addSelectColumn($alias . '.email_confirm');
            $criteria->addSelectColumn($alias . '.first_access');
            $criteria->addSelectColumn($alias . '.code_confirm');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(UsersTableMap::DATABASE_NAME)->getTable(UsersTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UsersTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UsersTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UsersTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Users or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Users object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Montanari\Propel\Users) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UsersTableMap::DATABASE_NAME);
            $criteria->add(UsersTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UsersQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UsersTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UsersTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UsersQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Users or Criteria object.
     *
     * @param mixed               $criteria Criteria or Users object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Users object
        }

        if ($criteria->containsKey(UsersTableMap::COL_ID) && $criteria->keyContainsValue(UsersTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UsersTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = UsersQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UsersTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UsersTableMap::buildTableMap();
